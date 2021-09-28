<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Catalog\Exercise;
use App\Domain\Catalog\ExerciseId;

interface ExerciseById
{
    public function findOne(ExerciseId $id): ?Exercise;
}
