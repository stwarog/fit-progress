<?php

declare(strict_types=1);

namespace App\Domain\Catalog;

use App\Domain\Name;

final class Exercise
{
    public function __construct(private ExerciseId $id, private Name $name)
    {
    }
}
