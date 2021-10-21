<?php

declare(strict_types=1);

namespace App\Training\Infrastructure\ReadModel;

use App\Training\Domain\TrainingId;

interface TrainingViewRepo
{
    /** @return array<TrainingView> */
    public function findAll(): array;

    public function findOne(TrainingId $trainingId): ?TrainingView;
}
