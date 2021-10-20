<?php

declare(strict_types=1);

namespace Unit\Training\Application\Command\CreateTraining;

use App\Training\Application\Command\CreateTraining\Command;
use PHPUnit\Framework\TestCase;

/** @covers \App\Training\Application\Command\CreateTraining\Command */
final class CommandTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Command('name', '2020-01-01', 'plan-id');
        $this->assertInstanceOf(Command::class, $sut);

        $this->assertEquals('name', $sut->name);
        $this->assertEquals('2020-01-01', $sut->date);
        $this->assertEquals('plan-id', $sut->planId);
    }
}
