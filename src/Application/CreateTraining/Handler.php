<?php

declare(strict_types=1);

namespace App\Application\CreateTraining;

use App\Domain\Repository\PlanById;
use App\Domain\Repository\TrainingStore;
use App\Domain\Training;
use App\Domain\TrainingId;
use App\Shared\Application\Command\CommandHandler;

final class Handler implements CommandHandler
{
    public function __construct(
        private TrainingStore $training,
        private PlanById $exists
    ) {
    }

    public function __invoke(Command $command): void
    {
        $training = new Training(
            $command->id ?? TrainingId::random(),
            $command->name,
            $this->exists,
            $command->date,
            $command->planId
        );

        $this->training->store($training);
    }
}
