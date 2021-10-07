<?php

declare(strict_types=1);

namespace App\Application\CreatePlan;

use App\Application\CommandHandler;
use App\Domain\Factory\Activity as ActivityFactory;
use App\Domain\Plan;
use App\Domain\PlanId;
use App\Domain\Repository\PlanStore;

final class Handler implements CommandHandler
{
    public function __construct(
        private PlanStore $plan,
        private ActivityFactory $factory
    ) {
    }

    public function __invoke(Command $command): void
    {
        $plan = new Plan(
            PlanId::random(),
            $command->name,
            array_map(fn(array $set) => $this->factory->createFrom($set), $command->exercises)
        );

        $this->plan->store($plan);
    }
}
