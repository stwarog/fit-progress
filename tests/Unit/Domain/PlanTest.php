<?php

declare(strict_types=1);

namespace Unit\Domain;

use App\Domain\Name;
use App\Domain\Plan;
use App\Domain\PlanId;
use InvalidArgumentException;
use Unit\TestCase;

/** @covers \App\Domain\Plan */
final class PlanTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Plan(PlanId::random(), new Name('FBW'));
        $this->assertInstanceOf(Plan::class, $sut);
    }

    public function testConstructorNoExerciseGivenThrowsError(): void
    {
        // Expect
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Plan accepts only App\Domain\Exercise, Unit\Domain\PlanTest given');

        // When given plan with class different from Exercise
        new Plan(PlanId::random(), new Name('FBW'), [$this]);
    }

    public function testAddExerciseExists(): void
    {
        // Given plan with one Exercise
        $sut = new Plan(
            PlanId::random(),
            new Name('FBW'),
            [$this->getExerciseStub()]
        );

        // When another one is added
        $sut->add(
            $this->getExerciseStub()
        );

        // Then it should be stored
        $this->assertCount(2, $sut);
    }
}
