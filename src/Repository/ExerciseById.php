<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exercise;
use App\ExerciseId;

interface ExerciseById
{
    public function findOne(ExerciseId $id): ?Exercise;
}
