<?php

declare(strict_types=1);

namespace Unit;

use App\Catalog\ExerciseId;
use App\Date;
use App\Exceptions\NotFoundException;
use App\PlanId;
use App\Repeats;
use App\Repository\ExerciseById;
use App\Training;
use App\TrainingId;
use App\Weight;
use PHPUnit\Framework\TestCase;

/** @covers \App\Training */
final class TrainingTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Training(
            new TrainingId('value'),
            new Date('2021-09-01'),
            PlanId::random()
        );
        $this->assertInstanceOf(Training::class, $sut);
    }

    public function testAddNotExerciseFoundThrowsException(): void
    {
        // Except
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Exercise not found');

        // Given Training
        $sut = new Training(TrainingId::random(), Date::now(), PlanId::random());

        // And an excercise
        $exerciseId = ExerciseId::random();

        // And repo that returns null
        $repo = $this->createMock(ExerciseById::class);
        $repo->method('findOne')->with($exerciseId)->willReturn(null);

        // When attempting to add new activity
        $sut->add(new Weight(100), new Repeats(5), $exerciseId, $repo);
    }
}
