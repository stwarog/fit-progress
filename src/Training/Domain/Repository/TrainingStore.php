<?php

namespace App\Training\Domain\Repository;

use App\Training\Domain\Training;

interface TrainingStore
{
    public function store(Training $training): void;
}
