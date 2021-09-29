<?php

declare(strict_types=1);

namespace Unit\Application\AddActivity;

use App\Application\AddActivity\Command;
use App\Application\AddActivity\Handler;
use App\Domain\Catalog\Exercise;
use App\Domain\Catalog\ExerciseId;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Name;
use App\Domain\Repository\ExerciseById;
use App\Domain\Repository\StoreTraining;
use App\Domain\Repository\TrainingById;
use App\Domain\Training;
use PHPUnit\Framework\TestCase;

/** @covers \App\Application\AddActivity\Handler */
final class HandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        // Given valid command
        $command = new Command('training-id', 20.0, 10, 'exc-id');

        // And existing Training
        $training = Training::create(new Name('Some training'));
        $repo = $this->createMock(TrainingById::class);
        $repo->method('findOne')->willReturn($training);
        $exists = $this->createMock(ExerciseById::class);
        $exists->method('findOne')->willReturn(new Exercise(ExerciseId::random(), new Name('name')));
        $store = $this->createMock(StoreTraining::class);
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
        $store = $this->createMock(StoreTraining::class);

        $handler = new Handler($repo, $store, $exists);

        // When called
        $handler($command);
    }
}
