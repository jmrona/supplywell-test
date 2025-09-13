<?php

declare(strict_types=1);

use TechTest\Inventory;
use TechTest\InventoryItemFactory;

describe('Inventory Management System', function () {

    it('should throw error for empty item name', function () {
        $this->expectException(\InvalidArgumentException::class);
        InventoryItemFactory::create(name: '', value: 10, sellIn: 5);
    });
    
    it('should throw error for negative sellIn', function () {
        $this->expectException(\InvalidArgumentException::class);
        InventoryItemFactory::create(name: 'Hat', value: 1, sellIn: -5);
    });

    it('should throw error if Gold Bar value is not 80', function () {
        $this->expectException(\InvalidArgumentException::class);
        InventoryItemFactory::create(name: 'Gold Bar', value: 70, sellIn: 5);
    });
    
    it('should throw error if non-Gold Bar item value exceeds 50', function () {
        $this->expectException(\InvalidArgumentException::class);
        InventoryItemFactory::create(name: 'Hat', value: 51, sellIn: 5);
    });

    it('should throw error if value is negative', function () {
        $this->expectException(\InvalidArgumentException::class);
        InventoryItemFactory::create(name: 'Hat', value: -1, sellIn: 5);
    });

    it('should correctly add items to inventory', function () {
        $inventory = new Inventory();
        $item = InventoryItemFactory::create(name: 'Hat', value: 10, sellIn: 5);
        $inventory->addItem($item);
        expect(count($inventory->listItems()))->toBe(1);
        expect($inventory->listItems()[0]->name())->toBe('Hat');
    });

    it('should decrease value of default item by 1 before sellIn', function () {
        $item = InventoryItemFactory::create(name: 'Hat', value: 10, sellIn: 5);
        $item->ageByOneDay();
        expect($item->value())->toBe(9);
    });

    it('should not go below 0 value for default items before sellIn', function () {
        $item = InventoryItemFactory::create(name: 'Hat', value: 0, sellIn: 5);
        $item->ageByOneDay();
        expect($item->value())->toBe(0);
    });

    it('should decrease value of default item by 2 after sellIn', function () {
        $item = InventoryItemFactory::create('Hat', 10, 0);
        $item->ageByOneDay();
        expect($item->value())->toBe(8);
    });

    it('should not go below 0 value for default items after sellIn', function () {
        $item = InventoryItemFactory::create(name: 'Hat', value: 0, sellIn: 0);
        $item->ageByOneDay();
        expect($item->value())->toBe(0);
    });

    it('should decrease value of perishable item by 2 before sellIn', function () {
        $item = InventoryItemFactory::create(name: 'Perishable Item', value: 10, sellIn: 5);
        $item->ageByOneDay();
        expect($item->value())->toBe(8);
    });

    it('should not go below 0 value for perishable items before sellIn', function () {
        $item = InventoryItemFactory::create(name: 'Perishable Item', value: 0, sellIn: 5);
        $item->ageByOneDay();
        expect($item->value())->toBe(0);
    });

    it('should decrease value of perishable item by 4 after sellIn', function () {
        $item = InventoryItemFactory::create(name: 'Perishable Item', value: 10, sellIn: 0);
        $item->ageByOneDay();
        expect($item->value())->toBe(6);
    });

    it('should not go below 0 value for perishable items after sellIn', function () {
        $item = InventoryItemFactory::create(name: 'Perishable Item', value: 0, sellIn: 0);
        $item->ageByOneDay();
        expect($item->value())->toBe(0);
    });

    it('increases value of vintage wine by 2', function () {
        $item = InventoryItemFactory::create('Vintage Wine', 10, 7);
        $item->ageByOneDay();
        expect($item->value())->toBe(12);
    });

    it('should not increase value of vintage wine above 50', function () {
        $item = InventoryItemFactory::create('Vintage Wine', 49, 7);
        $item->ageByOneDay();
        expect($item->value())->toBe(50);

        $item = InventoryItemFactory::create('Vintage Wine', 50, 7);
        $item->ageByOneDay();
        expect($item->value())->toBe(50);
    });

    it('increases value of world cup tickets correctly', function () {
        $item = InventoryItemFactory::create('World Cup Tickets', 10, 11);
        $item->ageByOneDay();
        expect($item->value())->toBe(11);

        $item = InventoryItemFactory::create('World Cup Tickets', 10, 10);
        $item->ageByOneDay();
        expect($item->value())->toBe(12);

        $item = InventoryItemFactory::create('World Cup Tickets', 10, 5);
        $item->ageByOneDay();
        expect($item->value())->toBe(13);

        $item = InventoryItemFactory::create('World Cup Tickets', 10, 0);
        $item->ageByOneDay();
        expect($item->value())->toBe(0);
    });

    it('should not increase value of world cup tickets above 50', function () {
        $item = InventoryItemFactory::create('World Cup Tickets', 49, 11);
        $item->ageByOneDay();
        expect($item->value())->toBe(50);

        $item = InventoryItemFactory::create('World Cup Tickets', 50, 10);
        $item->ageByOneDay();
        expect($item->value())->toBe(50);

        $item = InventoryItemFactory::create('World Cup Tickets', 50, 5);
        $item->ageByOneDay();
        expect($item->value())->toBe(50);
    });

    it('should maintain constant value for gold bars', function () {
        $item = InventoryItemFactory::create('Gold Bar', 80, 10);
        $item->ageByOneDay();
        expect($item->value())->toBe(80);

        $item = InventoryItemFactory::create('Gold Bar', 80, 0);
        $item->ageByOneDay();
        expect($item->value())->toBe(80);
    });

    it('valuesForDaysAhead returns correct simulation', function () {
        $inventory = new Inventory();
        $inventory->addItem(InventoryItemFactory::create('Hat', 10, 2));
        $inventory->addItem(InventoryItemFactory::create('Vintage Wine', 10, 2));
        $result = $inventory->valuesForDaysAhead(2);

        // Default item
        expect($result[0][0]['value'])->toBe(10); // Hat day 0 - value 10
        expect($result[1][0]['value'])->toBe(9);  // Hat day 1 - value 9
        expect($result[2][0]['value'])->toBe(8);  // Hat day 2 - value 8

        // Vintage Wine
        expect($result[0][1]['value'])->toBe(10); // Wine day 0 - value 10
        expect($result[1][1]['value'])->toBe(12); // Wine day 1 - value 12
        expect($result[2][1]['value'])->toBe(14); // Wine day 2 - value 14

        // Ensure Inventory state is unchanged
        expect($inventory->listItems()[0]->value())->toBe(10); // Hat
        expect($inventory->listItems()[1]->value())->toBe(10); // Vintage
    });

    it('valuesForDaysAhead throws exception for negative days', function () {
        $inventory = new Inventory();
        $inventory->addItem(InventoryItemFactory::create('Hat', 10, 2));

        $this->expectException(\InvalidArgumentException::class);
        $inventory->valuesForDaysAhead(-1);
    });
});
