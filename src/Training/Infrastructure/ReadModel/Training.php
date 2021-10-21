<?php

declare(strict_types=1);

namespace App\Training\Infrastructure\ReadModel;

use App\Shared\Infrastructure\ReadModel\View;
use App\Training\Domain\Date;
use App\Training\Domain\Name;
use App\Training\Domain\PlanId;
use App\Training\Domain\Status;
use App\Training\Domain\TrainingId;
use App\Training\Domain\Weight;
use JetBrains\PhpStorm\Pure;

final class Training implements View
{
    public string $id;
    public string $name;
    public string $status;
    public string $date;
    public ?string $planId;
    public ?string $planName;
    public int $doneRepeats = 0;
    public int $plannedRepeats = 0;
    public int $doneExercises = 0;
    public int $plannedExercises = 0;
    public float $liftedWeight = 0.0;

    #[Pure] public function __construct(
        TrainingId $id,
        Name $name,
        Status $status,
        Date $date,
        ?PlanId $planId = null,
        ?Name $planName = null,
        int $doneRepeats = 0,
        int $plannedRepeats = 0,
        int $doneExercises = 0,
        int $plannedExercises = 0,
        ?Weight $totalWeightLifted = null
    ) {
        $this->id = (string)$id;
        $this->name = (string)$name;
        $this->status = (string)$status;
        $this->date = (string)$date;
        $this->planId = !empty($planId) ? (string)$planId : null;
        $this->planName = !empty($planName) ? (string)$planName : null;
        $this->doneRepeats = $doneRepeats;
        $this->plannedRepeats = $plannedRepeats;
        $this->plannedExercises = $plannedExercises;
        $this->doneExercises = $doneExercises;
        $this->liftedWeight = $totalWeightLifted ? $totalWeightLifted->getValue() : 0.0;
    }

    public function jsonSerialize(): array
    {
        return $this->normalize();
    }

    #[Pure] public function normalize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'date' => $this->date,
            'planId' => $this->planId ?? null,
            'planName' => $this->planName ?? null,
            'doneRepeats' => $this->doneRepeats ?? 0,
            'plannedRepeats' => $this->plannedRepeats ?? 0,
            'doneExercises' => $this->doneExercises ?? 0,
            'plannedExercises' => $this->plannedExercises ?? 0,
            'liftedWeight' => $this->liftedWeight ?? 0.0,
        ];
    }

    public static function denormalize(array $data): Training
    {
        return new self(
            new TrainingId($data['id']),
            new Name($data['name']),
            new Status($data['status']),
            new Date($data['date']),
            !empty($data['planId']) ? new PlanId($data['planId']) : null,
            !empty($data['planName']) ? new Name($data['planName']) : null,
            (int)$data['doneRepeats'],
            (int)$data['plannedRepeats'],
            (int)$data['doneExercises'],
            (int)$data['plannedExercises'],
            new Weight((float)$data['liftedWeight'])
        );
    }
}
