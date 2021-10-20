<?php

declare(strict_types=1);

namespace Unit\Training\UI\Cli;

use App\Application\CreatePlan\Command as CreatePlanCommand;
use App\Shared\Application\Command\CommandBus;
use App\Training\UI\Cli\CreatePlan;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/** @covers \App\Training\UI\Cli\CreatePlan */
final class CreatePlanTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new CreatePlan($this->createMock(CommandBus::class));
        $this->assertInstanceOf(Command::class, $sut);
    }

    /** @throws Exception */
    public function testExecute(): void
    {
        // Given input with arguments
        $name = 'Plan name';
        $exercises = ['20,10,id'];

        $input = $this->createMock(InputInterface::class);
        $input->method('getArgument')->withConsecutive(
            ['exercises'],
            ['name'],
        )->willReturnOnConsecutiveCalls(
            $exercises,
            $name
        );

        // And command bus that should be called
        $bus = $this->createMock(CommandBus::class);
        $bus->expects($this->once())->method('handle')->willReturnCallback(function (CreatePlanCommand $c) use (
            $name,
            $exercises
        ) {
            $this->assertEquals($name, $c->name);
            $expected = [
                [
                    'weight' => 20,
                    'repeats' => 10,
                    'exercise_id' => 'id',
                ]
            ];
            $this->assertEquals($expected, $c->exercises);
        });

        // When Given command is executed
        $command = new CreatePlan($bus);
        $result = $command->run($input, $this->createMock(OutputInterface::class));
        $this->assertSame(0, $result);
    }

    /** @throws Exception */
    public function testExecuteWithoutOptional(): void
    {
        // Given input with arguments
        $name = 'Plan name';

        $input = $this->createMock(InputInterface::class);
        $input->method('getArgument')->withConsecutive(
            ['exercises'],
            ['name'],
        )->willReturnOnConsecutiveCalls(
            null,
            $name,
        );

        // And command bus that should be called
        $bus = $this->createMock(CommandBus::class);
        $bus->expects($this->once())->method('handle')->willReturnCallback(function (CreatePlanCommand $c) use (
            $name,
        ) {
            $this->assertEquals($name, $c->name);
        });

        // When Given command is executed
        $command = new CreatePlan($bus);
        $result = $command->run($input, $this->createMock(OutputInterface::class));
        $this->assertSame(0, $result);
    }
}
