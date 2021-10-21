<?php

declare(strict_types=1);

namespace Unit\Training\Domain;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Training\Domain\Catalog\Exercise as CatalogExercise;
use App\Training\Domain\Catalog\ExerciseById as CatalogExerciseById;
use App\Training\Domain\Catalog\ExerciseId as CatalogExerciseId;
use App\Training\Domain\Exercise;
use App\Training\Domain\ExerciseId;
use App\Training\Domain\Name;
use App\Training\Domain\Repeats;
use App\Training\Domain\Weight;
use PHPUnit\Framework\TestCase;

/** @covers \App\Training\Domain\Exercise */
final class ExerciseTest extends TestCase
{
    public function testConstructor(): void
    {
        // Given ExerciseById that returns Exercise
        $byId = $this->createMock(CatalogExerciseById::class);
        $byId->method('findOne')->willReturn(
            new CatalogExercise(CatalogExerciseId::random(), new Name('name'))
        );

        // When initialized
        $sut = new Exercise(
            new ExerciseId('value'),
            new Weight(100),
            new Repeats(5),
            CatalogExerciseId::random(),
            $byId
        );

        // Then
        $this->assertInstanceOf(Exercise::class, $sut);
    }

    public function testConstructorExerciseNotFoundThrowsException(): void
    {
        // Expect
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Exercise not found');

        // Given ExerciseById that not returns Exercise
        $byId = $this->createMock(CatalogExerciseById::class);

        // When initialized & Then
        new Exercise(
            new ExerciseId('value'),
            new Weight(100),
            new Repeats(5),
            CatalogExerciseId::random(),
            $byId
        );
    }
}
