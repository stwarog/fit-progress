<?php

declare(strict_types=1);

namespace App\Application\AddActivity;

use App\Domain\Activity;
use App\Domain\ActivityId;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Repository\ExerciseById;
use App\Domain\Repository\StoreTraining;
use App\Domain\Repository\TrainingById;

final class Handler
{
    public function __construct(
        private TrainingById $repo,
        private StoreTraining $training,
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