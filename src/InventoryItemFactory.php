<?php

declare(strict_types=1);

namespace TechTest;

class InventoryItemFactory
{
    public static function create(string $name, int $value, int $sellIn): InventoryItem
    {
        if (trim($name) === '') {
            throw new \InvalidArgumentException('Name cannot be empty.');
        }

        if ($value < 0 || $sellIn < 0) {
            throw new \InvalidArgumentException('Value and SellIn must be non-negative integers.');
        }

        if ($name === 'Gold Bar' && $value !== 80) {
            throw new \InvalidArgumentException('Gold Bar must have a value of 80.');
        }

        if ($value > 50 && $name !== 'Gold Bar') {
            throw new \InvalidArgumentException('Value cannot exceed 50 for non-Gold Bar items.');
        }

        return match ($name) {
            'Vintage Wine' => new VintageWine($name, $value, $sellIn),
            'World Cup Tickets' => new WorldCupTickets($name, $value, $sellIn),
            'Gold Bar' => new GoldBar($name, $value, $sellIn),
            'Perishable Item' => new PerishableItem($name, $value, $sellIn),
            default => new DefaultItem($name, $value, $sellIn),
        };
    }
}
