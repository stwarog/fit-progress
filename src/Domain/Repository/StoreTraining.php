<?php

namespace App\Domain\Repository;

use App\Domain\Training;

interface StoreTraining
{
    public function store(Training $training): void;
}
