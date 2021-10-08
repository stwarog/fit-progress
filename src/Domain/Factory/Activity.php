<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Catalog\ExerciseId as CatalogExerciseId;
use App\Domain\Exercise as ExerciseEntity;
use App\Domain\ExerciseId;
use App\Domain\Repeats;
use App\Domain\Repository\ExerciseById;
use App\Domain\Weight;

final class Activity
{
    public function __construct(private ExerciseById $exists)
    {
    }

    public function createFrom(array $data): ExerciseEntity
    {
        return new ExerciseEntity(
            ExerciseId::random(),
            new Weight((float)$data['weight']),
            new Repeats((int)$data['repeats']),
            new CatalogExerciseId($data['exercise_id']),
            $this->exists
        );
    }
}
