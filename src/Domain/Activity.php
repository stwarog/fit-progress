<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Catalog\ExerciseById;
use App\Domain\Catalog\ExerciseId;
use App\Domain\Exceptions\NotFoundException;

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
