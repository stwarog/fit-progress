<?php

declare(strict_types=1);

namespace App;

final class Training
{
    public function __construct(private TrainingId $id, Date $date, private PlanId $plan)
    {
    }

    public function add(Activity $exercise): void
    {
    }
}
