<?php

declare(strict_types=1);

namespace App\Domain;

use Countable as Countable;

final class Training implements Countable
{
    private array $activities = [];

    public function __construct(
        private TrainingId $id,
        private Name $name,
        private ?Date $date = null,
        private ?PlanId $plan = null
    ) {
        $this->date = $date ?? Date::now();
    }

    public static function create(Name $name, ?Date $date = null, ?PlanId $planId = null): self
    {
        return new self(
            TrainingId::random(),
            $name,
            $date,
            $planId
        );
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
