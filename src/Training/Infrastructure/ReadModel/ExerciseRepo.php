<?php

declare(strict_types=1);

namespace App\Training\Infrastructure\ReadModel;

use App\Training\Domain\TrainingId;

interface ExerciseRepo
{
    /**
     * @param TrainingId $trainingId
     * @return array<Exercise>
     */
    public function findAll(TrainingId $trainingId): array;
}
