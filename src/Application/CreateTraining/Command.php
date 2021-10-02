<?php

declare(strict_types=1);

namespace App\Application\CreateTraining;

use App\Application\Command as CommandMarker;
use App\Domain\Date;
use App\Domain\Name;
use App\Domain\PlanId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class Command implements CommandMarker
{
    public Name $name;
    public ?Date $date;
    public ?PlanId $planId;

    public function __construct(string $name, ?string $date = null, ?string $planId = null)
    {
        $this->name = new Name($name);
        $this->date = $date ? new Date($date) : null;
        $this->planId = $planId ? new PlanId($planId) : null;
    }
}
