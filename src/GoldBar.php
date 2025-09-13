<?php

declare(strict_types=1);

namespace TechTest;

class GoldBar extends InventoryItem
{
    public function ageByOneDay(): void
    {
        $this->value = 80;
    }
}
