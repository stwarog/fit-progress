<?php

declare(strict_types=1);

namespace Unit;

use App\Exercise;
use App\ExerciseId;
use App\Name;
use App\Plan;
use App\PlanId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Plan */
final class PlanTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Plan(PlanId::random(), new Name('FBW'), [new Exercise(ExerciseId::random(), new Name('name'))]);
        $this->assertInstanceOf(Plan::class, $sut);
    }

    public function testConstructorMissingExercisesThrowsError(): void
    {
        // Expect
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing exercises in plan');

        // When given plan without any exercises
        new Plan(PlanId::random(), new Name('FBW'), []);
    }

    public function testConstructorNoExerciseGivenThrowsError(): void
    {
        // Expect
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Plan accepts only Exercises, Unit\PlanTest given');

        // When given plan with class different from Exercise
        new Plan(PlanId::random(), new Name('FBW'), [$this]);
    }
}
