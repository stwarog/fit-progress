<?php

declare(strict_types=1);

namespace App\Training\Domain\Factory;

use App\Training\Domain\Catalog\ExerciseById;
use App\Training\Domain\Catalog\ExerciseId as CatalogExerciseId;
use App\Training\Domain\Exercise as ExerciseEntity;
use App\Training\Domain\ExerciseId;
use App\Training\Domain\Repeats;
use App\Training\Domain\Weight;

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
