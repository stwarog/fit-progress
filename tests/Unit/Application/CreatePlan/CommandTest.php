<?php

declare(strict_types=1);

namespace Unit\Application\CreatePlan;

use App\Application\CreatePlan\Command;
use PHPUnit\Framework\TestCase;

/** @covers \App\Application\CreatePlan\Command */
final class CommandTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Command('name');
        $this->assertInstanceOf(Command::class, $sut);

        $this->assertEquals('name', $sut->name);
    }
}
