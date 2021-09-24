<?php

declare(strict_types=1);

namespace App;

final class Training
{
    /**
     * @param TrainingId $id
     * @param Plan<Exercise> $exercises
     */
    public function __construct(private TrainingId $id, private Plan $exercises)
    {
    }
}
