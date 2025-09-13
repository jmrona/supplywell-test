<?php

declare(strict_types=1);

namespace TechTest;

abstract class InventoryItem
{
    public function __construct(
        protected string $name,
        protected int $value,
        protected int $sellIn
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function sellIn(): int
    {
        return $this->sellIn;
    }

    abstract public function ageByOneDay(): void;

    protected function clampValue(): void
    {
        if ($this->name === 'Gold Bar') {
            $this->value = 80;

            return;
        }

        if ($this->value < 0) {
            $this->value = 0;
        } elseif ($this->value > 50) {
            $this->value = 50;
        }
    }
}
