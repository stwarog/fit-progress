<?php

declare(strict_types=1);

namespace App\Application\CreatePlan;

use App\Application\CommandHandler;
use App\Domain\Plan;
use App\Domain\PlanId;
use App\Domain\Repository\PlanStore;

final class Handler implements CommandHandler
{
    public function __construct(
        private PlanStore $plan
    ) {
    }

    public function __invoke(Command $command): void
    {
        $Plan = new Plan(
            PlanId::random(),
            $command->name,
        );

        $this->plan->store($Plan);
    }
}
