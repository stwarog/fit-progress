<?php

declare(strict_types=1);

namespace App\Application\CreatePlan;

use App\Domain\Name;
use App\Domain\PlanId;
use App\Shared\Application\Command\Command as CommandMarker;
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
