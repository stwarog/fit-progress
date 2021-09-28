<?php

declare(strict_types=1);

namespace Unit\UI\Cli;

use App\UI\Cli\TrainingCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;

/** @covers \App\UI\Cli\TrainingCommand */
final class TrainingCommandTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new TrainingCommand();
        $this->assertInstanceOf(Command::class, $sut);
    }
}
