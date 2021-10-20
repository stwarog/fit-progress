<?php

declare(strict_types=1);

namespace App\Training\Domain;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Training\Domain\Catalog\ExerciseById;
use App\Training\Domain\Catalog\ExerciseId;

final class Activity
{
    private int $repeats;
    private float $weight;
    private string $date;

    public function __construct(
        private ActivityId $id,
        Weight $weight,
        Repeats $repeats,
        private ExerciseId $exerciseId,
        private ExerciseById $exists
    ) {
        if (empty($this->exists->findOne($exerciseId))) {
            throw new NotFoundException('Exercise not found');
        }
        $this->repeats = $repeats->getValue();
        $this->weight = $weight->getValue();
        $this->date = (string)DateTime::now();
    }
}
