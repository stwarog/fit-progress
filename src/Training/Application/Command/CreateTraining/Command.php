<?php

declare(strict_types=1);

namespace App\Training\Application\Command\CreateTraining;

use App\Shared\Application\Command\Command as CommandMarker;
use App\Training\Domain\Date;
use App\Training\Domain\Name;
use App\Training\Domain\PlanId;
use App\Training\Domain\TrainingId;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class Command implements CommandMarker
{
    public Name $name;
    public ?Date $date;
    public ?TrainingId $id;
    public ?PlanId $planId;

    public function __construct(string $name, ?string $date = null, ?string $planId = null, ?string $id = null)
    {
        if ($id) {
            $this->id = new TrainingId($id);
        }
        $this->name = new Name($name);
        $this->date = $date ? new Date($date) : null;
        $this->planId = $planId ? new PlanId($planId) : null;
    }
}
