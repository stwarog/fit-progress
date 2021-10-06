<?php

declare(strict_types=1);

namespace Unit\Application\CreatePlan;

use App\Application\CreatePlan\Command;
use App\Application\CreatePlan\Handler;
use App\Domain\Repository\PlanStore;
use Unit\TestCase;

/** @covers \App\Application\CreatePlan\Handler */
final class HandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        // Given valid command
        $command = new Command('name');

        // And existing Plan
        $store = $this->createMock(PlanStore::class);
        $store->expects($this->once())->method('store');

        $handler = new Handler($store);

        // When called
        $handler($command);
    }
}
