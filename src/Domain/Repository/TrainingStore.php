<?php

namespace App\Domain\Repository;

use App\Domain\Training;

interface TrainingStore
{
    public function store(Training $training): void;
}
