<?php

declare(strict_types=1);

namespace Unit\UI\Cli;

use App\Shared\Application\Query\Collection;
use App\Shared\Application\Query\QueryBus;
use App\UI\Cli\FindTrainings;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Unit\TestCase;

/** @covers \App\UI\Cli\FindTrainings */
final class FindTrainingsTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new FindTrainings($this->createMock(QueryBus::class));
        $this->assertInstanceOf(Command::class, $sut);
    }

    /** @throws Exception */
    public function testExecute(): void
    {
        // Given input
        $input = $this->createMock(InputInterface::class);
        $collection = new Collection([
            ['field' => 'value']
        ]);

        // And command bus that should be called
        $bus = $this->createMock(QueryBus::class);
        $bus->expects($this->once())->method('ask')->willReturn($collection);

        // When Given command is executed
        $command = new FindTrainings($bus);
        $result = $command->run($input, new NullOutput());
        $this->assertSame(0, $result);
    }
}
