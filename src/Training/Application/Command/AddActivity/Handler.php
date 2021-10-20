<?php

declare(strict_types=1);

namespace App\Training\Application\Command\AddActivity;

use App\Shared\Application\Command\CommandHandler;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Training\Domain\Activity;
use App\Training\Domain\ActivityId;
use App\Training\Domain\Catalog\ExerciseById;
use App\Training\Domain\Repository\TrainingById;
use App\Training\Domain\Repository\TrainingStore;

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
