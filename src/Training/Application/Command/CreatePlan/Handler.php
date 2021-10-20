<?php

declare(strict_types=1);

namespace App\Training\Application\Command\CreatePlan;

use App\Domain\Factory\Activity as ActivityFactory;
use App\Domain\Plan;
use App\Domain\PlanId;
use App\Domain\Repository\PlanStore;
use App\Shared\Application\Command\CommandHandler;

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
            $command->id ?? PlanId::random(),
            $command->name,
            array_map(fn(array $set) => $this->factory->createFrom($set), $command->exercises)
        );

        $this->plan->store($plan);
    }
}
