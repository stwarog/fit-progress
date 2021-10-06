<?php

declare(strict_types=1);

namespace App\Application\CreatePlan;

use App\Application\Command as CommandMarker;
use App\Domain\Name;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

#[Immutable]
final class Command implements CommandMarker
{
    public Name $name;

    #[Pure] public function __construct(string $name)
    {
        $this->name = new Name($name);
    }
}
