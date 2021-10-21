<?php

declare(strict_types=1);

namespace Unit\Training\Infrastructure\ReadModel\Presenter\CLI;

use App\Training\Domain\Date;
use App\Training\Domain\ExerciseId;
use App\Training\Domain\Name;
use App\Training\Domain\Repeats;
use App\Training\Domain\Status;
use App\Training\Domain\TrainingId;
use App\Training\Domain\Weight;
use App\Training\Infrastructure\ReadModel\Exercise;
use App\Training\Infrastructure\ReadModel\ExerciseRepo;
use App\Training\Infrastructure\ReadModel\Presenter\CLI\TrainingDetails;
use App\Training\Infrastructure\ReadModel\Presenter\TrainingDetails as TrainingDetailsPresenter;
use App\Training\Infrastructure\ReadModel\Training;
use App\Training\Infrastructure\ReadModel\TrainingRepo;
use Unit\TestCase;

final class TrainingDetailsTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new TrainingDetails(
            $this->createMock(TrainingRepo::class),
            $this->createMock(ExerciseRepo::class)
        );
        $this->assertInstanceOf(TrainingDetailsPresenter::class, $sut);
    }

    public function testGetResult(): void
    {
        // Given Training View
        $trainingView = new Training(
            new TrainingId('trainingId'),
            new Name('name'),
            new Status('started'),
            new Date('2020-01-01')
        );

        // And it's Repo
        $t = $this->createMock(TrainingRepo::class);
        $t->method('findOne')->willReturn($trainingView);

        // And Exercises with repo
        $exerciseView1 = new Exercise(new Weight(20), new Repeats(10), new ExerciseId('exercise-id'));
        $e = $this->createMock(ExerciseRepo::class);
        $e->method('findAll')->willReturn([$exerciseView1]);

        $expected = [
            'training' => [
                'id' => 'trainingId',
                'name' => 'name',
                'status' => 'started',
                'date' => '2020-01-01',
                'planId' => null,
                'planName' => null,
                'doneRepeats' => 0,
                'plannedRepeats' => 0,
                'doneExercises' => 0,
                'plannedExercises' => 0,
                'liftedWeight' => 0.0,
            ],
            'exercises' => [
                [
                    'weight' => 20.0,
                    'repeats' => 10,
                    'exerciseId' => 'exercise-id'
                ]
            ]
        ];

        $sut = new TrainingDetails($t, $e);

        // When presented
        $actual = $sut->getResult(new TrainingId('trainingId'));

        // Then output should be as expected
        $this->assertSame($expected, $actual);
    }
}
