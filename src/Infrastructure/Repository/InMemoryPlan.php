<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Date;
use App\Domain\Name;
use App\Domain\Plan;
use App\Domain\PlanId;
use App\Domain\Repository\PlanById;
use App\Domain\TrainingId;

final class InMemoryPlan implements PlanById
{
    private array $catalog = [];

    public function __construct(private PlanById $exists)
    {
        $names = [
            ['4ef022ee-bd51-405e-b1a6-1234123', 'FBW'],
        ];

        foreach ($names as $dataSet) {
            [$id, $name] = $dataSet;
            $this->catalog[$id] = new Plan(
                new TrainingId($id),
                new Name($name),
                $this->exists,
                Date::now(),
                PlanId::random()
            );
        }
    }

    public function findOne(PlanId $id): ?Plan
    {
        return $this->catalog[(string)$id] ?? null;
    }
}
