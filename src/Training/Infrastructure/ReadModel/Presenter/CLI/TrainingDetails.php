<?php

declare(strict_types=1);

namespace App\Training\Infrastructure\ReadModel\Presenter\CLI;

use App\Training\Domain\TrainingId;
use App\Training\Infrastructure\ReadModel\ExerciseRepo;
use App\Training\Infrastructure\ReadModel\Presenter\TrainingDetails as Presenter;
use App\Training\Infrastructure\ReadModel\TrainingRepo;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

final class TrainingDetails implements Presenter
{
    public function __construct(private TrainingRepo $training, private ExerciseRepo $exercises)
    {
    }

    #[ArrayShape([
        'training' => "\App\Training\Infrastructure\ReadModel\Training|null",
        'exercises' => "array|array[]"
    ])] public function getResult(TrainingId $trainingId): array
    {
        return [
            'training' => $this->training->findOne($trainingId)->jsonSerialize(),
            'exercises' => array_map(
                fn(JsonSerializable $i) => $i->jsonSerialize(),
                $this->exercises->findAll($trainingId)
            )
        ];
    }
}
