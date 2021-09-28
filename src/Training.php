<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\NotFoundException;
use App\Repository\ExerciseById;

final class Training
{
    public function __construct(private TrainingId $id, Date $date, private PlanId $plan)
    {
    }

    public function add(Weight $weight, Repeats $repeats, ExerciseId $id, ExerciseById $repo): void
    {
        $exercise = $repo->findOne($id);

        if (empty($exercise)) {
            throw new NotFoundException('Exercise not found');
        }
    }
}
