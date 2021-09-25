<?php

declare(strict_types=1);

namespace Unit;

use App\Exercise;
use App\Id;
use App\Name;
use App\Plan;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Plan */
final class PlanTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Plan([new Exercise(new Id('id'), new Name('name'))]);
        $this->assertInstanceOf(Plan::class, $sut);
    }

    public function testConstructorMissingExercisesThrowsError(): void
    {
        // Expect
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing exercises in plan');

        // When given plan without any exercises
        new Plan([]);
    }

    public function testConstructorNoExerciseGivenThrowsError(): void
    {
        // Expect
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Plan accepts only Exercises, Unit\PlanTest given');

        // When given plan with class different from Exercise
        new Plan([$this]);
    }
}
