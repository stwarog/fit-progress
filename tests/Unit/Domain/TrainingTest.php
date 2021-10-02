<?php

declare(strict_types=1);

namespace Unit\Domain;

use App\Domain\Activity;
use App\Domain\ActivityId;
use App\Domain\Catalog\Exercise;
use App\Domain\Catalog\ExerciseId;
use App\Domain\Date;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Name;
use App\Domain\Plan;
use App\Domain\PlanId;
use App\Domain\Repeats;
use App\Domain\Repository\ExerciseById;
use App\Domain\Repository\PlanById;
use App\Domain\Training;
use App\Domain\TrainingId;
use App\Domain\Weight;
use Countable;
use PHPUnit\Framework\TestCase;

/** @covers \App\Domain\Training */
final class TrainingTest extends TestCase
{
    public function testConstructor(): Training
    {
        $sut = new Training(
            new TrainingId('value'),
            new Name('some name'),
            $this->createMock(PlanById::class),
            new Date('2021-09-01')
        );
        $this->assertInstanceOf(Training::class, $sut);
        $this->assertInstanceOf(Countable::class, $sut);

        return $sut;
    }

    public function testConstructorWithoutOptional(): void
    {
        // Given training 1 & 2 without optional args
        $sut1 = new Training(
            new TrainingId('value'),
            new Name('some name'),
            $this->createMock(PlanById::class),
        );

        $sut2 = new Training(
            new TrainingId('value'),
            new Name('some name'),
            $this->createMock(PlanById::class),
        );

        // When created & Then should be equal
        $this->assertEquals($sut1, $sut2);
    }

    public function testConstructorWithoutOptionalFail(): void
    {
        // Given training 1 & 2 without optional args
        $sut1 = new Training(
            new TrainingId('value'),
            new Name('some name'),
            $this->createMock(PlanById::class),
        );

        $sut2 = new Training(
            new TrainingId('value'),
            new Name('some name'),
            $this->createMock(PlanById::class),
            new Date('2020-01-01')
        );

        // When created & Then should be equal
        $this->assertNotEquals($sut1, $sut2);
    }

    /** @depends testConstructor */
    public function testAddActivity(Training $sut): void
    {
        // When added new activity
        $exists = $this->createMock(ExerciseById::class);
        $exists->method('findOne')->willReturn(new Exercise(ExerciseId::random(), new Name('name')));

        $activity = new Activity(
            ActivityId::random(),
            TrainingId::random(),
            new Weight(100),
            new Repeats(10),
            ExerciseId::random(),
            $exists
        );

        $sut->add($activity);

        // Then count should be increased
        $this->assertCount(1, $sut);
    }

    public function testCreate(): void
    {
        $sut = Training::create(new Name('Some training'), $this->createMock(PlanById::class));
        $this->assertInstanceOf(Training::class, $sut);
    }

    public function testCreatePlanIdProvidedExistsShouldBeVerified(): void
    {
        // Given plan
        $planId = PlanId::random();
        $exists = $this->createMock(PlanById::class);
        $exists->expects($this->once())->method('findOne')
            ->willReturn(
                new Plan(
                    PlanId::random(),
                    new Name('name'),
                    [new Exercise(ExerciseId::random(), new Name('name'))]
                )
            );

        // When new training created
        $sut = Training::create(
            new Name('Some training'),
            $exists,
            Date::now(),
            $planId
        );

        // Then
        $this->assertInstanceOf(Training::class, $sut);
    }

    public function testCreatePlanIdProvidedExistsShouldBeVerifiedFails(): void
    {
        // Expects
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Plan not found');

        // Given not existing plan
        $planId = PlanId::random();
        $exists = $this->createMock(PlanById::class);

        // When new training created with plan id provided
        $sut = Training::create(
            new Name('Some training'),
            $exists,
            Date::now(),
            $planId
        );
    }
}
