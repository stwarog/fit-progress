<?php

declare(strict_types=1);

namespace App\UI\Cli;

use App\Application\CommandBus;
use App\Application\CreateTraining\Command as CreateTrainingCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateTraining extends Command
{
    protected static $defaultName = 'app:training:create';
    protected static $defaultDescription = 'Creates new training';

    protected function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
        $this->addArgument('date', InputArgument::OPTIONAL);
        $this->addArgument('plan', InputArgument::OPTIONAL);
        parent::configure();
    }

    public function __construct(private CommandBus $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = new CreateTrainingCommand(
            $input->getArgument('name'),
            $input->getArgument('date'),
            $input->getArgument('plan'),
        );

        $this->bus->handle($command);

        return Command::SUCCESS;
    }
}