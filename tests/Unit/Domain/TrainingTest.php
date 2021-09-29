<?php

declare(strict_types=1);

namespace Unit\Domain;

use App\Domain\Activity;
use App\Domain\ActivityId;
use App\Domain\Catalog\Exercise;
use App\Domain\Catalog\ExerciseId;
use App\Domain\Date;
use App\Domain\Name;
use App\Domain\PlanId;
use App\Domain\Repeats;
use App\Domain\Repository\ExerciseById;
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
            new Date('2021-09-01'),
            PlanId::random()
        );
        $this->assertInstanceOf(Training::class, $sut);
        $this->assertInstanceOf(Countable::class, $sut);

        return $sut;
    }

    /** @depends testConstructor */
    public function testAddActivity(Training $sut): void
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
    }

    public function testCreate(): void
    {
        $sut = Training::create(new Name('Some training'));
        $this->assertInstanceOf(Training::class, $sut);
    }
}
