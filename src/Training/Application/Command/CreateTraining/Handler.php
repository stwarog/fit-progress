<?php

declare(strict_types=1);

namespace App\Training\Application\Command\CreateTraining;

use App\Shared\Application\Command\CommandHandler;
use App\Training\Domain\Repository\PlanById;
use App\Training\Domain\Repository\TrainingStore;
use App\Training\Domain\Training;
use App\Training\Domain\TrainingId;

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
