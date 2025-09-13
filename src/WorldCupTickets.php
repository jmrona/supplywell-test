<?php

declare(strict_types=1);

namespace TechTest;

class WorldCupTickets extends InventoryItem
{
    public function ageByOneDay(): void
    {
        $increaseBy = match (true) {
            $this->sellIn > 10 => 1,
            $this->sellIn > 5 => 2,
            $this->sellIn > 0 => 3,
            default => $this->value = 0,
        };

        $this->value += $increaseBy;
        $this->sellIn -= 1;
        $this->clampValue();
    }
}
