<?php

declare(strict_types=1);

namespace TechTest;

class PerishableItem extends InventoryItem
{
    public function ageByOneDay(): void
    {
        $decreaseBy = $this->sellIn > 0 ? 2 : 4;
        $this->value -= $decreaseBy;
        $this->sellIn -= 1;
        $this->clampValue();
    }
}
