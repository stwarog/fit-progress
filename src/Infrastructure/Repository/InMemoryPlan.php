<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Catalog\ExerciseId as CatalogExerciseId;
use App\Domain\Exercise;
use App\Domain\ExerciseId;
use App\Domain\Name;
use App\Domain\Plan;
use App\Domain\PlanId;
use App\Domain\Repeats;
use App\Domain\Repository\ExerciseById;
use App\Domain\Repository\PlanById;
use App\Domain\Weight;

final class InMemoryPlan implements PlanById
{
    private array $catalog = [];

    public function __construct(private ExerciseById $exists)
    {
        $names = [
            ['4ef022ee-bd51-405e-b1a6-1234123', 'FBW'],
        ];

        foreach ($names as $dataSet) {
            [$id, $name] = $dataSet;
            $this->catalog[$id] = new Plan(
                new PlanId($id),
                new Name($name),
                [
                    new Exercise(
                        ExerciseId::random(),
                        new Weight(20),
                        new Repeats(10),
                        new CatalogExerciseId('a7041851-d794-4153-a337-db468eefd7b5'),
                        $this->exists
                    )
                ]
            );
        }
    }

    public function findOne(PlanId $id): ?Plan
    {
        return $this->catalog[(string)$id] ?? null;
    }
}
