<?php

declare(strict_types=1);

namespace Unit\Training\Application\Command\CreatePlan;

use App\Domain\Factory\Activity as ActivityFactory;
use App\Domain\Plan;
use App\Domain\PlanId;
use App\Domain\Repository\PlanStore;
use App\Training\Application\Command\CreatePlan\Command;
use App\Training\Application\Command\CreatePlan\Handler;
use Unit\TestCase;

/** @covers \App\Training\Application\Command\CreatePlan\Handler */
final class HandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        // Given valid command and no id provided
        $command = new Command('name', [
            [20.0, 10, 'exercise-id'],
            [20.0, 10, 'exercise-id-2'],
        ]);

        // And existing Plan
        $store = $this->createMock(PlanStore::class);
        $store->expects($this->once())->method('store');

        // And Activity Factory
        $serializer = new ActivityFactory($this->exerciseByIdStub());

        $handler = new Handler($store, $serializer);

        // When called
        $handler($command);
    }

    public function testInvokeWithIdProvided(): void
    {
        // Given valid command and id provided
        $command = new Command(
            'name',
            [[20.0, 10, 'exercise-id']],
            'some-id'
        );

        // And existing Plan
        $store = $this->createMock(PlanStore::class);
        $store->expects($this->once())->method('store')->willReturnCallback(
            function (Plan $p) {
                $this->assertEquals(new PlanId('some-id'), $p->getId());
            }
        );

        // And Activity Factory
        $serializer = new ActivityFactory($this->exerciseByIdStub());

        $handler = new Handler($store, $serializer);

        // When called
        $handler($command);
    }
}
