<?php

declare(strict_types=1);

namespace App\Training\Application\Command\AddActivity;

use App\Domain\Catalog\ExerciseId;
use App\Domain\Repeats;
use App\Domain\TrainingId;
use App\Domain\Weight;
use App\Shared\Application\Command\Command as CommandMarker;
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