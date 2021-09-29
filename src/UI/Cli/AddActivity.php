<?php

declare(strict_types=1);

namespace App\UI\Cli;

use App\Application\AddActivity\Command as AddActivityCommand;
use App\Application\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class AddActivity extends Command
{
    protected static $defaultName = 'app:activity:create';
    protected static $defaultDescription = 'Creates new activity';

    protected function configure()
    {
        $this->addArgument('training', InputArgument::REQUIRED);
        $this->addArgument('weight', InputArgument::REQUIRED);
        $this->addArgument('repeats', InputArgument::REQUIRED);
        $this->addArgument('exercise', InputArgument::REQUIRED);
        parent::configure();
    }

    public function __construct(private CommandBus $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = new AddActivityCommand(
            $input->getArgument('training'),
            (float)$input->getArgument('weight'),
            (int)$input->getArgument('repeats'),
            $input->getArgument('exercise'),
        );

        $this->bus->handle($command);

        return Command::SUCCESS;
    }
}
