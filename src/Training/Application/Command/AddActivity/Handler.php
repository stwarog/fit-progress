<?php

declare(strict_types=1);

namespace App\Training\Application\Command\AddActivity;

use App\Domain\Activity;
use App\Domain\ActivityId;
use App\Domain\Catalog\ExerciseById;
use App\Domain\Repository\TrainingById;
use App\Domain\Repository\TrainingStore;
use App\Shared\Application\Command\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;

final class Handler implements CommandHandler
{
    public function __construct(
        private TrainingById $repo,
        private TrainingStore $training,
        private ExerciseById $exists
    ) {
    }

    public function __invoke(Command $command): void
    {
        $training = $this->repo->findOne($command->trainingId);

        if (empty($training)) {
            throw new NotFoundException('Training not found');
        }

        $training->add(
            new Activity(
                ActivityId::random(),
                $command->weight,
                $command->repeats,
                $command->exerciseId,
                $this->exists
            )
        );

        $this->training->store($training);
    }
}
