<?php

declare(strict_types=1);

namespace Unit\Training\Application\Command\AddActivity;

use App\Domain\Catalog\ExerciseById;
use App\Domain\Name;
use App\Domain\Repository\PlanById;
use App\Domain\Repository\TrainingById;
use App\Domain\Repository\TrainingStore;
use App\Domain\Training;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Training\Application\Command\AddActivity\Command;
use App\Training\Application\Command\AddActivity\Handler;
use Unit\TestCase;

/** @covers \App\Training\Application\Command\AddActivity\Handler */
final class HandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        // Given valid command
        $command = new Command('training-id', 20.0, 10, 'exc-id');

        // And existing Training
        $training = Training::create(new Name('Some training'), $this->createMock(PlanById::class));
        $repo = $this->createMock(TrainingById::class);
        $repo->method('findOne')->willReturn($training);
        $exists = $this->exerciseByIdStub();
        $store = $this->createMock(TrainingStore::class);
        $store->expects($this->once())->method('store')->with($training);

        $handler = new Handler($repo, $store, $exists);

        // When called
        $handler($command);

        // Then new activity should be added
        $this->assertCount(1, $training);
    }

    public function testInvokeTrainingNotFoundThrowsException(): void
    {
        // Expect
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Training not found');

        // Given valid command
        $command = new Command('training-id', 20.0, 10, 'exc-id');

        // And not existing Training
        $repo = $this->createMock(TrainingById::class);
        $repo->method('findOne')->willReturn(null);
        $exists = $this->createMock(ExerciseById::class);
        $store = $this->createMock(TrainingStore::class);

        $handler = new Handler($repo, $store, $exists);

        // When called
        $handler($command);
    }
}
