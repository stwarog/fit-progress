<?php

declare(strict_types=1);

namespace App\Application\CreatePlan;

use App\Application\Command as CommandMarker;
use App\Domain\Name;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class Command implements CommandMarker
{
    public Name $name;

    /**
     * @var array<array{weight: float, repeats: float, exercise_id: string}>
     */
    public array $exercises = [];

    public function __construct(string $name, array $exercises = [])
    {
        $this->name = new Name($name);
        $this->exercises = array_map(
            fn(array $set) => array_combine(['weight', 'repeats', 'exercise_id'], $set),
            $exercises
        );
    }
}
