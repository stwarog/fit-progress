<?php

declare(strict_types=1);

namespace Unit\Training\Application\Command\AddActivity;

use App\Training\Application\Command\AddActivity\Command;
use PHPUnit\Framework\TestCase;

/** @covers \App\Training\Application\Command\AddActivity\Command */
final class CommandTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Command('id', 20.0, 10, 'exc-id');
        $this->assertInstanceOf(Command::class, $sut);

        $this->assertSame('id', (string)$sut->trainingId);
        $this->assertSame(20.0, $sut->weight->getValue());
        $this->assertSame(10, $sut->repeats->getValue());
        $this->assertSame('exc-id', (string)$sut->exerciseId);
    }
}
