<?php

namespace App\Training\Infrastructure\ReadModel\Presenter;

use App\Training\Domain\TrainingId;

interface TrainingDetails
{
    public function getResult(TrainingId $trainingId): array;
}
