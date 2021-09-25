<?php

declare(strict_types=1);

namespace App;

final class Training
{
    /**
     * @param TrainingId $id
     * @param Date $date
     * @param Plan<Exercise> $plan
     */
    public function __construct(private TrainingId $id, Date $date, private Plan $plan)
    {
    }
}
