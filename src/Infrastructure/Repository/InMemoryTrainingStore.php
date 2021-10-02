<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Date;
use App\Domain\Name;
use App\Domain\PlanId;
use App\Domain\Repository\PlanById;
use App\Domain\Repository\TrainingById;
use App\Domain\Training;
use App\Domain\TrainingId;

final class InMemoryTrainingStore implements TrainingById
{
    private array $catalog = [];

    public function __construct(private PlanById $exists)
    {
        $names = [
            ['4ef022ee-bd51-405e-b1a6-e23139a3e9d3', 'FBW'],
            ['fe28fe0f-3fe7-4bcf-8a14-ddd2bd60822d', 'Interval'],
        ];

        foreach ($names as $dataSet) {
            [$id, $name] = $dataSet;
            $this->catalog[$id] = new Training(
                new TrainingId($id),
                new Name($name),
                $this->exists,
                Date::now(),
                PlanId::random()
            );
        }
    }

    public function findOne(TrainingId $id): ?Training
    {
        return $this->catalog[(string)$id] ?? null;
    }

    public function store(Training $training): void
    {
        $this->catalog[(string)$training->getId()] = $training;
    }
}
