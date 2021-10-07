<?php

declare(strict_types=1);

namespace Unit\Application\CreatePlan;

use App\Application\CreatePlan\Command;
use App\Application\CreatePlan\Handler;
use App\Domain\Factory\Activity as ActivityFactory;
use App\Domain\Repository\PlanStore;
use Unit\TestCase;

/** @covers \App\Application\CreatePlan\Handler */
final class HandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        // Given valid command
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
}
