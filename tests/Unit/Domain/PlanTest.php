<?php

declare(strict_types=1);

namespace Unit\Domain;

use App\Domain\Catalog\Exercise;
use App\Domain\Catalog\ExerciseId;
use App\Domain\Name;
use App\Domain\Plan;
use App\Domain\PlanId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Domain\Plan */
final class PlanTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Plan(PlanId::random(), new Name('FBW'), [ExerciseId::random()]);
        $this->assertInstanceOf(Plan::class, $sut);
    }

    public function testConstructorNoExerciseGivenThrowsError(): void
    {
        // Expect
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Plan accepts only Exercises, Unit\Domain\PlanTest given');

        // When given plan with class different from Exercise
        new Plan(PlanId::random(), new Name('FBW'), [$this]);
    }

    public function testAddExerciseExists(): void
    {
        // Given plan with one Exercise
        $sut = new Plan(
            PlanId::random(),
            new Name('FBW'),
            [ExerciseId::random()]
        );

        // When another one is added
        $sut->add(
            new Exercise(ExerciseId::random(), new Name('name 2'))
        );

        // Then it should be stored
        $this->assertCount(2, $sut);
    }
}
