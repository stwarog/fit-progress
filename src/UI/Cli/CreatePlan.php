<?php

declare(strict_types=1);

namespace App\UI\Cli;

use App\Application\CommandBus;
use App\Application\CreatePlan\Command as CreatePlanCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreatePlan extends Command
{
    protected static $defaultName = 'app:plan:create';
    protected static $defaultDescription = 'Creates new Plan';

    protected function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
        parent::configure();
    }

    public function __construct(private CommandBus $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = new CreatePlanCommand(
            $input->getArgument('name'),
        );

        $this->bus->handle($command);

        return Command::SUCCESS;
    }
}
