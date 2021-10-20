<?php

declare(strict_types=1);

namespace App\UI\Cli;

use App\Application\CreatePlan\Command as CreatePlanCommand;
use App\Shared\Application\Command\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class CreatePlan extends Command
{
    protected static $defaultName = 'app:plan:create';
    protected static $defaultDescription = 'Creates new Plan';

    public function __construct(private CommandBus $bus)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
        $this->addOption('id', null, InputOption::VALUE_OPTIONAL, 'Uuid of plan id');
        $this->addArgument(
            'exercises',
            InputArgument::IS_ARRAY,
            'Should be valid json: "[[weight: float, repeats: int, exercise_id: str]]"'
        );
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $exercises = $input->getArgument('exercises');
        if ($exercises) {
            $exercises = array_map(fn(string $set) => explode(',', $set), $exercises);
        }

        $command = new CreatePlanCommand(
            $input->getArgument('name'),
            $exercises ?? [],
            $input->getOption('id') ?? null
        );

        $this->bus->handle($command);

        return Command::SUCCESS;
    }
}
