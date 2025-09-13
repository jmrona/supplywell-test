<?php

declare(strict_types=1);

namespace TechTest;

class VintageWine extends InventoryItem
{
    public function ageByOneDay(): void
    {
        $increaseBy = 2;
        $this->value += $increaseBy;
        $this->sellIn -= 1;
        $this->clampValue();
    }
}
