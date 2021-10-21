<?php

declare(strict_types=1);

namespace Unit\Training\Domain;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Training\Domain\Activity;
use App\Training\Domain\ActivityId;
use App\Training\Domain\Catalog\Exercise;
use App\Training\Domain\Catalog\ExerciseById;
use App\Training\Domain\Catalog\ExerciseId;
use App\Training\Domain\Date;
use App\Training\Domain\DateTime;
use App\Training\Domain\Exceptions\InvalidStatus;
use App\Training\Domain\Name;
use App\Training\Domain\Plan;
use App\Training\Domain\PlanId;
use App\Training\Domain\Repeats;
use App\Training\Domain\Repository\PlanById;
use App\Training\Domain\Status;
use App\Training\Domain\Training;
use App\Training\Domain\TrainingId;
use App\Training\Domain\Weight;
use Countable;
use Unit\TestCase;

/** @covers \App\Training\Domain\Training */
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

    public function testTrainingInitiallyPlanned(): Training
    {
        // When Given Training
        $sut = new Training(
            new TrainingId('value'),
            new Name('some name'),
            $this->createMock(PlanById::class),
            new Date('2021-09-01')
        );

        // Then it should be in planned Status
        $expected = new Status('planned');
        $actual = $sut->getStatus();
        $this->assertEquals($expected, $actual);

        // And no started date should be present
        $this->assertEmpty($sut->getDateStarted());

        return $sut;
    }

    /** @depends testTrainingInitiallyPlanned */
    public function testStartOnPlannedTraining(Training $sut): Training
    {
        // Given Planned Training

        // When started
        $sut->start();

        // Then status should change and start date
        $actualStatus = $sut->getStatus();
        $actualDateStarted = $sut->getDateStarted();

        $this->assertEquals(new Status('started'), $actualStatus);
        $this->assertEquals(DateTime::now(), $actualDateStarted);

        return $sut;
    }

    /** @depends testStartOnPlannedTraining */
    public function testStartOnAlreadyStartedTraining(Training $sut): void
    {
        // Given Started Training

        // When started again
        $sut->start();

        // Then status should still be started
        $actualStatus = $sut->getStatus();

        $this->assertEquals(new Status('started'), $actualStatus);
    }

    public function testStartOnEndedTraining(): void
    {
        // Expect
        $this->expectException(InvalidStatus::class);
        $this->expectExceptionMessage('Invalid Training status');

        // Given Ended | Skipped Training
        $sut = new Training(
            new TrainingId('value'),
            new Name('some name'),
            $this->createMock(PlanById::class),
            new Date('2021-09-01'),
        );

        $sut->end();

        // When started again
        $sut->start();
    }

    public function testStartOnSkippedTraining(): void
    {
        // Expect
        $this->expectException(InvalidStatus::class);
        $this->expectExceptionMessage('Invalid Training status');

        // Given Ended | Skipped Training
        $sut = new Training(
            new TrainingId('value'),
            new Name('some name'),
            $this->createMock(PlanById::class),
            new Date('2021-09-01'),
        );

        $sut->skip();

        // When started again
        $sut->start();
    }

    public function testSkipOnStartedTraining(): void
    {
        // Expect
        $this->expectException(InvalidStatus::class);
        $this->expectExceptionMessage('Invalid Training status');

        // Given Ended | Skipped Training
        $sut = new Training(
            new TrainingId('value'),
            new Name('some name'),
            $this->createMock(PlanById::class),
            new Date('2021-09-01'),
        );

        $sut->start();

        // When started again
        $sut->skip();
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
    public function testAddActivity(Training $sut): Training
    {
        // When added new activity
        $exists = $this->createMock(ExerciseById::class);
        $exists->method('findOne')->willReturn(new Exercise(ExerciseId::random(), new Name('name')));

        $activity = new Activity(
            ActivityId::random(),
            new Weight(100),
            new Repeats(10),
            ExerciseId::random(),
            $exists
        );

        $sut->add($activity);

        // Then count should be increased
        $this->assertCount(1, $sut);

        return $sut;
    }

    /** @depends testAddActivity */
    public function testAddActivityShouldChangeTrainingStatusToStarted(Training $sut): void
    {
        $expected = new Status('started');
        $actual = $sut->getStatus();
        $this->assertEquals($expected, $actual);
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
                    [$this->getExerciseStub()]
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
