<?php

declare(strict_types=1);

namespace App\Training\Application\Query\GetTrainingDetails;

use App\Shared\Application\Query\Query as QueryMarker;
use App\Training\Domain\TrainingId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class Query implements QueryMarker
{
    public TrainingId $trainingId;

    public function __construct(string $trainingId)
    {
        $this->trainingId = new TrainingId($trainingId);
    }
}
