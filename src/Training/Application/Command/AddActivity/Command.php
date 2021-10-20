<?php

declare(strict_types=1);

namespace App\Training\Application\Command\AddActivity;

use App\Shared\Application\Command\Command as CommandMarker;
use App\Training\Domain\Catalog\ExerciseId;
use App\Training\Domain\Repeats;
use App\Training\Domain\TrainingId;
use App\Training\Domain\Weight;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class Command implements CommandMarker
{
    public TrainingId $trainingId;
    public Weight $weight;
    public Repeats $repeats;
    public ExerciseId $exerciseId;

    public function __construct(string $trainingId, float $weight, int $repeats, string $exerciseId)
    {
        $this->trainingId = new TrainingId($trainingId);
        $this->weight = new Weight($weight);
        $this->repeats = new Repeats($repeats);
        $this->exerciseId = new ExerciseId($exerciseId);
    }
}
