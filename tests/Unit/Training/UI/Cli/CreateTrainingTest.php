<?php

declare(strict_types=1);

namespace Unit\Training\UI\Cli;

use App\Application\CreateTraining\Command as CreateTrainingCommand;
use App\Shared\Application\Command\CommandBus;
use App\Training\UI\Cli\CreateTraining;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/** @covers \App\Training\UI\Cli\CreateTraining */
final class CreateTrainingTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new CreateTraining($this->createMock(CommandBus::class));
        $this->assertInstanceOf(Command::class, $sut);
    }

    /** @throws Exception */
    public function testExecute(): void
    {
        // Given input with arguments
        $name = 'Training name';
        $date = '2021-01-01';
        $planId = 'fe28fe0f-3fe7-4bcf-8a14-ddd2bd60822d';

        $input = $this->createMock(InputInterface::class);
        $input->method('getArgument')->withConsecutive(
            ['name'],
            ['date'],
            ['plan'],
        )->willReturnOnConsecutiveCalls(
            $name,
            $date,
            $planId
        );

        // And command bus that should be called
        $bus = $this->createMock(CommandBus::class);
        $bus->expects($this->once())->method('handle')->willReturnCallback(function (CreateTrainingCommand $c) use (
            $name,
            $date,
            $planId
        ) {
            $this->assertEquals($name, $c->name);
            $this->assertEquals($date, $c->date);
            $this->assertEquals($planId, $c->planId);
        });

        // When Given command is executed
        $command = new CreateTraining($bus);
        $result = $command->run($input, $this->createMock(OutputInterface::class));
        $this->assertSame(0, $result);
    }

    /** @throws Exception */
    public function testExecuteWithoutOptional(): void
    {
        // Given input with arguments
        $name = 'Training name';

        $input = $this->createMock(InputInterface::class);
        $input->method('getArgument')->withConsecutive(
            ['name'],
        )->willReturnOnConsecutiveCalls(
            $name,
        );

        // And command bus that should be called
        $bus = $this->createMock(CommandBus::class);
        $bus->expects($this->once())->method('handle')->willReturnCallback(function (CreateTrainingCommand $c) use (
            $name,
        ) {
            $this->assertEquals($name, $c->name);
        });

        // When Given command is executed
        $command = new CreateTraining($bus);
        $result = $command->run($input, $this->createMock(OutputInterface::class));
        $this->assertSame(0, $result);
    }
}
