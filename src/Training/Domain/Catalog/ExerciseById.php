<?php

declare(strict_types=1);

namespace App\Training\Domain\Catalog;

interface ExerciseById
{
    public function findOne(ExerciseId $id): ?Exercise;
}
