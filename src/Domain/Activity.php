<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Catalog\ExerciseId;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Repository\ExerciseById;

final class Activity
{
    public function __construct(
        private ActivityId $id,
        private Weight $weight,
        private Repeats $repeats,
        private ExerciseId $exerciseId,
        private ExerciseById $exists
    ) {
        if (empty($this->exists->findOne($exerciseId))) {
            throw new NotFoundException('Exercise not found');
        }
    }
}
