<?php

declare(strict_types=1);

namespace App\Training\Infrastructure\ReadModel;

interface TrainingRepo
{
    /** @return array<TrainingView> */
    public function findAll(): array;
}
