<?php

declare(strict_types=1);

namespace App\Domain\Catalog;

interface ExerciseById
{
    public function findOne(ExerciseId $id): ?Exercise;
}
