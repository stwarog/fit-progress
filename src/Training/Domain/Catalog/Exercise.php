<?php

declare(strict_types=1);

namespace App\Training\Domain\Catalog;

use App\Training\Domain\Name;

final class Exercise
{
    public function __construct(private ExerciseId $id, private Name $name)
    {
    }
}
