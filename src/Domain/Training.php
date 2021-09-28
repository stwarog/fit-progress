<?php

declare(strict_types=1);

namespace App\Domain;

use Countable as Countable;

final class Training implements Countable
{
    private array $activities = [];

    public function __construct(private TrainingId $id, Date $date, private PlanId $plan)
    {
    }

    public function add(Activity $exercise): void
    {
        $this->activities[] = $exercise;
    }

    public function count(): int
    {
        return count($this->activities);
    }

    public function getId(): TrainingId
    {
        return $this->id;
    }
}
