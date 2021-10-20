<?php

declare(strict_types=1);

namespace Unit\Training\Application\Command\CreateTraining;

use App\Training\Application\Command\CreateTraining\Command;
use App\Training\Application\Command\CreateTraining\Handler;
use App\Training\Domain\Repository\TrainingStore;
use App\Training\Domain\Training;
use App\Training\Domain\TrainingId;
use Unit\TestCase;

/** @covers \App\Training\Application\Command\CreateTraining\Handler */
final class HandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        // Given valid command
        $command = new Command('name', '2020-01-01', 'plan-id');

        // And existing Training
        $store = $this->createMock(TrainingStore::class);
        $store->expects($this->once())->method('store');
        $exists = $this->planByIdStub();

        $handler = new Handler($store, $exists);

        // When called
        $handler($command);
    }

    public function testInvokeWithIdProvided(): void
    {
        // Given valid command
        $command = new Command('name', '2020-01-01', 'plan-id', 'some-id');

        // And existing Training
        $store = $this->createMock(TrainingStore::class);
        $store->expects($this->once())->method('store')->willReturnCallback(
            function (Training $t) {
                $this->assertEquals(new TrainingId('some-id'), $t->getId());
            }
        );
        $exists = $this->planByIdStub();

        $handler = new Handler($store, $exists);

        // When called
        $handler($command);
    }
}
