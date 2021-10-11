<?php

declare(strict_types=1);

namespace Unit\Domain;

use App\Domain\Activity;
use App\Domain\ActivityId;
use App\Domain\Catalog\Exercise;
use App\Domain\Catalog\ExerciseById;
use App\Domain\Catalog\ExerciseId;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Name;
use App\Domain\Repeats;
use App\Domain\Weight;
use PHPUnit\Framework\TestCase;

/** @covers \App\Domain\Activity */
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
