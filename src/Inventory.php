<?php

declare(strict_types=1);

namespace TechTest;

class Inventory
{
    /** @var InventoryItem[] */
    private array $items = [];

    public function addItem(InventoryItem $item): void
    {
        $this->items[] = $item;
    }

    public function ageByOneDay(): void
    {
        foreach ($this->items as $item) {
            $item->ageByOneDay();
        }
    }

    public function totalValue(): int
    {
        return array_sum(array_map(fn ($item) => $item->value(), $this->items));
    }

    /**
     * Returns an array where the keys are days ahead (0 to $days) and the values are the total inventory value on that day.
     *
     * @param  int  $days  Number of days ahead to simulate
     * @return array<int, array<string, int>> Array of total values indexed by day
     */
    public function valuesForDaysAhead(int $days): array
    {
        if ($days < 0) {
            throw new \InvalidArgumentException('Days must be a non-negative integer.');
        }

        $snapshots = [];
        $clones = array_map(fn ($item) => clone $item, $this->items);

        for ($day = 0; $day <= $days; $day++) {
            $snapshots[$day] = array_map(
                fn ($item) => [
                    'name' => $item->name(),
                    'value' => $item->value(),
                ], $clones
            );

            foreach ($clones as $item) {
                $item->ageByOneDay();
            }
        }

        return $snapshots;
    }

    /** @return InventoryItem[] */
    public function listItems(): array
    {
        return $this->items;
    }
}
