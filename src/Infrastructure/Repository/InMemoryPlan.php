<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Catalog\Exercise;
use App\Domain\Catalog\ExerciseId;
use App\Domain\Name;
use App\Domain\Plan;
use App\Domain\PlanId;
use App\Domain\Repository\PlanById;

final class InMemoryPlan implements PlanById
{
    private array $catalog = [];

    public function __construct()
    {
        $names = [
            ['4ef022ee-bd51-405e-b1a6-1234123', 'FBW'],
        ];

        foreach ($names as $dataSet) {
            [$id, $name] = $dataSet;
            $this->catalog[$id] = new Plan(
                new PlanId($id),
                new Name($name),
                [new Exercise(ExerciseId::random(), new Name('Pushes'))]
            );
        }
    }

    public function findOne(PlanId $id): ?Plan
    {
        return $this->catalog[(string)$id] ?? null;
    }
}
