<?php

declare(strict_types=1);

namespace App\Training\Infrastructure\ReadModel;

use App\Training\Domain\TrainingId;

interface TrainingRepo
{
    /** @return array<Training> */
    public function findAll(): array;

    public function findOne(TrainingId $trainingId): ?Training;
}
