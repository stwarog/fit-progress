<?php

declare(strict_types=1);

namespace App\Training\Domain;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Training\Domain\Catalog\ExerciseById as CatalogExerciseById;
use App\Training\Domain\Catalog\ExerciseId as CatalogExerciseId;

final class Exercise
{
    private int $repeats;
    private float $weight;

    public function __construct(
        private ExerciseId $id,
        Weight $weight,
        Repeats $repeats,
        private CatalogExerciseId $exerciseId,
        private CatalogExerciseById $exists
    ) {
        if (empty($this->exists->findOne($exerciseId))) {
            throw new NotFoundException('Exercise not found');
        }
        $this->repeats = $repeats->getValue();
        $this->weight = $weight->getValue();
    }
}
