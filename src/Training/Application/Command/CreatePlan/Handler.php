<?php

declare(strict_types=1);

namespace App\Training\Application\Command\CreatePlan;

use App\Shared\Application\Command\CommandHandler;
use App\Training\Domain\Factory\Activity as ActivityFactory;
use App\Training\Domain\Plan;
use App\Training\Domain\PlanId;
use App\Training\Domain\Repository\PlanStore;

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
