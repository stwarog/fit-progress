<?php

declare(strict_types=1);

namespace App\UI\Cli;

use App\Application\AddActivity\Command as AddActivityCommand;
use App\Application\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class TrainingCommand extends Command
{
    protected static $defaultName = 'app:activity:create';
    protected static $defaultDescription = 'Creates new activity';

    public function __construct(private CommandBus $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = new AddActivityCommand(
            '4ef022ee-bd51-405e-b1a6-e23139a3e9d3',
            200,
            5,
            'fe28fe0f-3fe7-4bcf-8a14-ddd2bd60822d'
        );

        $this->bus->handle($command);

        return Command::SUCCESS;
    }
}
