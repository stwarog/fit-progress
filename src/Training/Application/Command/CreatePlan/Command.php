<?php

declare(strict_types=1);

namespace App\Training\Application\Command\CreatePlan;

use App\Shared\Application\Command\Command as CommandMarker;
use App\Training\Domain\Name;
use App\Training\Domain\PlanId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class Command implements CommandMarker
{
    public ?PlanId $id = null;
    public Name $name;

    /**
     * @var array<array{weight: float, repeats: float, exercise_id: string}>
     */
    public array $exercises = [];

    public function __construct(string $name, array $exercises = [], ?string $id = null)
    {
        if ($id) {
            $this->id = new PlanId($id);
        }
        $this->name = new Name($name);
        $this->exercises = array_map(
            fn(array $set) => array_combine(['weight', 'repeats', 'exercise_id'], $set),
            $exercises
        );
    }
}
