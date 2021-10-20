<?php

declare(strict_types=1);

namespace Unit\Training\Domain;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Training\Domain\Activity;
use App\Training\Domain\ActivityId;
use App\Training\Domain\Catalog\Exercise;
use App\Training\Domain\Catalog\ExerciseById;
use App\Training\Domain\Catalog\ExerciseId;
use App\Training\Domain\Name;
use App\Training\Domain\Repeats;
use App\Training\Domain\Weight;
use PHPUnit\Framework\TestCase;

/** @covers \App\Training\Domain\Activity */
final class ActivityTest extends TestCase
{
    public function testConstructor(): void
    {
        // Given ExerciseById that returns Exercise
        $byId = $this->createMock(ExerciseById::class);
        $byId->method('findOne')->willReturn(new Exercise(ExerciseId::random(), new Name('name')));

        // When initialized
        $sut = new Activity(
            new ActivityId('value'),
            new Weight(100),
            new Repeats(5),
            ExerciseId::random(),
            $byId
        );

        // Then
        $this->assertInstanceOf(Activity::class, $sut);
    }

    public function testConstructorExerciseNotFoundThrowsException(): void
    {
        // Expect
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Exercise not found');

        // Given ExerciseById that not returns Exercise
        $byId = $this->createMock(ExerciseById::class);

        // When initialized & Then
        new Activity(
            new ActivityId('value'),
            new Weight(100),
            new Repeats(5),
            ExerciseId::random(),
            $byId
        );
    }
}
