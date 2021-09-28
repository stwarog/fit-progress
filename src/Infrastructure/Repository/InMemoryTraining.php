<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Date;
use App\Domain\PlanId;
use App\Domain\Repository\StoreTraining;
use App\Domain\Repository\TrainingById;
use App\Domain\Training;
use App\Domain\TrainingId;

final class InMemoryTraining implements TrainingById, StoreTraining
{
    private array $catalog = [];

    public function __construct()
    {
        $names = [
            ['4ef022ee-bd51-405e-b1a6-e23139a3e9d3'],
            ['fe28fe0f-3fe7-4bcf-8a14-ddd2bd60822d'],
        ];

        foreach ($names as $dataSet) {
            [$id] = $dataSet;
            $this->catalog[$id] = new Training(new TrainingId($id), Date::now(), PlanId::random());
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
