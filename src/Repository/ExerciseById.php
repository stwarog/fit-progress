<?php

declare(strict_types=1);

namespace App\Repository;

use App\Catalog\Exercise;
use App\Catalog\ExerciseId;

interface ExerciseById
{
    public function findOne(ExerciseId $id): ?Exercise;
}
