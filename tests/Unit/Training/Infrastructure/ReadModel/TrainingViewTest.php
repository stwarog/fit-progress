<?php

declare(strict_types=1);

namespace Unit\Training\Infrastructure\ReadModel;

use App\Training\Domain\Date;
use App\Training\Domain\Name;
use App\Training\Domain\PlanId;
use App\Training\Domain\Status;
use App\Training\Domain\TrainingId;
use App\Training\Domain\Weight;
use App\Training\Infrastructure\ReadModel\TrainingView;
use JsonSerializable;
use Unit\TestCase;

/** @covers \App\Training\Infrastructure\ReadModel\TrainingView */
final class TrainingViewTest extends TestCase
{
    public function testConstructor(): TrainingView
    {
        // Given Value Objects needed to create a View
        $id = TrainingId::random();
        $name = new Name('Training name');
        $status = new Status(Status::PLANNED);
        $date = new Date('2021-01-01');
        $planId = PlanId::random();
        $planName = new Name('Plan name');
        $doneRepeats = 1;
        $plannedRepeats = 2;
        $doneExercises = 3;
        $plannedExercises = 4;
        $totalWeightLifted = new Weight(1000);

        // When new instance is created
        $sut = new TrainingView(
            $id,
            $name,
            $status,
            $date,
            $planId,
            $planName,
            $doneRepeats,
            $plannedRepeats,
            $doneExercises,
            $plannedExercises,
            $totalWeightLifted
        );

        // Then
        $this->assertInstanceOf(JsonSerializable::class, $sut);

        return $sut;
    }

    /** @depends testConstructor */
    public function testSerializeAndDeserialize(TrainingView $sut): void
    {
        $serialize = serialize($sut);
        $normalize = unserialize($serialize);
        $this->assertEquals($sut, $normalize);
    }

    /** @depends testConstructor */
    public function testDenormalize(TrainingView $sut): void
    {
        $normalized = $sut->normalize();
        $this->assertEquals($sut, TrainingView::denormalize($normalized));
    }
}
