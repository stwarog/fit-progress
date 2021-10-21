<?php

declare(strict_types=1);

namespace App\Training\Infrastructure\ReadModel;

use App\Shared\Infrastructure\ReadModel\View;
use App\Training\Domain\ExerciseId;
use App\Training\Domain\Repeats;
use App\Training\Domain\Weight;
use JsonSerializable;

final class Exercise implements View
{
    public float $weight;
    public int $repeats;
    public ?string $exerciseId;

    public function __construct(Weight $weight, Repeats $repeats, ?ExerciseId $exerciseId)
    {
        $this->weight = $weight->getValue();
        $this->repeats = $repeats->getValue();
        $this->exerciseId = $exerciseId ? (string)$exerciseId : null;
    }

    public function normalize(): array
    {
        return [
            'weight' => $this->weight,
            'repeats' => $this->repeats,
            'exerciseId' => $this->exerciseId,
        ];
    }

    public static function denormalize(array $data): JsonSerializable
    {
        return new self(
            new Weight((float)$data['weight']),
            new Repeats((int)$data['repeats']),
            !empty($data['exerciseId']) ? new ExerciseId($data['exerciseId']) : null
        );
    }

    public function jsonSerialize(): array
    {
        return $this->normalize();
    }
}
