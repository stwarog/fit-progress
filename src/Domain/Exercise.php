<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Catalog\ExerciseById as CatalogExerciseById;
use App\Domain\Catalog\ExerciseId as CatalogExerciseId;
use App\Domain\Exceptions\NotFoundException;

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
