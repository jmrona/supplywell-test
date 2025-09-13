<?php

declare(strict_types=1);

namespace TechTest;

class DefaultItem extends InventoryItem
{
    public function ageByOneDay(): void
    {
        $decreaseBy = $this->sellIn > 0 ? 1 : 2;
        $this->value -= $decreaseBy;
        $this->sellIn -= 1;
        $this->clampValue();
    }
}
