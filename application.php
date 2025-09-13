<?php

declare(strict_types=1);


require_once __DIR__ . '/src/Inventory.php';
require_once __DIR__ . '/src/InventoryItem.php';
require_once __DIR__ . '/src/InventoryItemFactory.php';

require_once __DIR__ . '/src/DefaultItem.php';
require_once __DIR__ . '/src/PerishableItem.php';
require_once __DIR__ . '/src/VintageWine.php';
require_once __DIR__ . '/src/WorldCupTickets.php';
require_once __DIR__ . '/src/GoldBar.php';

use TechTest\Inventory;
use TechTest\InventoryItemFactory;

$inventory = new Inventory();
$inventory->addItem(InventoryItemFactory::create(name: 'Hat', value: 10, sellIn: 7));
$inventory->addItem(InventoryItemFactory::create(name: 'Frying Pan', value: 10, sellIn: 4));
$inventory->addItem(InventoryItemFactory::create(name: 'Vintage Wine', value: 32, sellIn: 0));
$inventory->addItem(InventoryItemFactory::create(name: 'World Cup Tickets', value: 10, sellIn: 8));
$inventory->addItem(InventoryItemFactory::create(name: 'Milk', value: 10, sellIn: 7));
$inventory->addItem(InventoryItemFactory::create(name: 'Gold Bar', value: 80, sellIn: 0));
$inventory->addItem(InventoryItemFactory::create(name: 'Perishable Item', value: 20, sellIn: 5));


for ($i = 0; $i < 10; $i++) {
    echo 'DAY ' . $i . "\n";
    foreach ($inventory->listItems() as $item) {
        $item->ageByOneDay();
        echo $item->name() . ': ' . $item->value() . "\n";
    }
    echo "\n";
}

// Uncomment to see the full 50-day simulation
// echo "50-Day Simulation:\n";
// $simulatedValues = $inventory->valuesForDaysAhead(50);
// foreach ($simulatedValues as $day => $items) {
//     echo "---------------------\n";
//     echo " DAY $day            \n";
//     echo "---------------------\n";
//
//     foreach ($items as $item) {
//         echo $item['name'] . ': ' . $item['value'] . "\n";
//     }
//     echo "\n";
// }

