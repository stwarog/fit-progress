<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Exceptions\NotFoundException;
use App\Domain\Repository\PlanById;
use Countable as Countable;

final class Training implements Countable
{
    private array $activities = [];

    public function __construct(
        private TrainingId $id,
        private Name $name,
        private PlanById $exists,
        private ?Date $date = null,
        private ?PlanId $planId = null
    ) {
        $this->date = $date ?? Date::now();

        if (!empty($planId) && empty($exists->findOne($planId))) {
            throw new NotFoundException('Plan not found');
        }
    }

    public static function create(Name $name, PlanById $exists, ?Date $date = null, ?PlanId $planId = null): self
    {
        return new self(
            TrainingId::random(),
            $name,
            $exists,
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
