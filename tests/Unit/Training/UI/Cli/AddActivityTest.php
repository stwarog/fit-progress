<?php

declare(strict_types=1);

namespace Unit\Training\UI\Cli;

use App\Application\AddActivity\Command as AddActivityCommand;
use App\Shared\Application\Command\CommandBus;
use App\Training\UI\Cli\AddActivity;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/** @covers \App\Training\UI\Cli\AddActivity */
final class AddActivityTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new AddActivity($this->createMock(CommandBus::class));
        $this->assertInstanceOf(Command::class, $sut);
    }

    /** @throws Exception */
    public function testExecute(): void
    {
        // Given input with arguments
        $trainingId = '4ef022ee-bd51-405e-b1a6-e23139a3e9d3';
        $weight = 200;
        $repeats = 5;
        $exerciseId = 'fe28fe0f-3fe7-4bcf-8a14-ddd2bd60822d';

        $input = $this->createMock(InputInterface::class);
        $input->method('getArgument')->withConsecutive(
            ['training'],
            ['weight'],
            ['repeats'],
            ['exercise'],
        )->willReturnOnConsecutiveCalls(
            $trainingId,
            $weight,
            $repeats,
            $exerciseId
        );

        // And command bus that should be called
        $bus = $this->createMock(CommandBus::class);
        $bus->expects($this->once())->method('handle')->willReturnCallback(function (AddActivityCommand $c) use (
            $trainingId,
            $repeats,
            $weight,
            $exerciseId
        ) {
            $this->assertSame((string)$c->exerciseId, $exerciseId);
            $this->assertEquals($c->weight->getValue(), $weight);
            $this->assertEquals($c->repeats->getValue(), $repeats);
            $this->assertSame((string)$c->trainingId, $trainingId);
        });

        // When Given command is executed
        $command = new AddActivity($bus);
        $result = $command->run($input, $this->createMock(OutputInterface::class));
        $this->assertSame(0, $result);
    }
}
