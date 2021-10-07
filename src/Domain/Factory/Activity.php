<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Activity as ActivityEntity;
use App\Domain\ActivityId;
use App\Domain\Catalog\ExerciseId;
use App\Domain\Repeats;
use App\Domain\Repository\ExerciseById;
use App\Domain\TrainingId;
use App\Domain\Weight;

final class Activity
{
    public function __construct(private ExerciseById $exists)
    {
    }

    public function createFrom(array $data): ActivityEntity
    {
        return new ActivityEntity(
            ActivityId::random(),
            TrainingId::random(),
            new Weight((float)$data['weight']),
            new Repeats((int)$data['repeats']),
            new ExerciseId($data['exercise_id']),
            $this->exists
        );
    }
}
