<?php

declare(strict_types=1);

namespace App\Training\UI\Cli;

use App\Shared\Application\Query\QueryBus;
use App\Shared\Application\Query\Result;
use App\Training\Application\Query\GetTrainingDetails\Query;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

# todo missing test
final class Wizzard extends Command
{
    protected static $defaultName = 'app:wizard';
    protected static $defaultDescription = 'Interactive wizard to make a Training';

    public function __construct(private QueryBus $bus)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('training', InputArgument::REQUIRED);
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $query = new Query($input->getArgument('training'));

        $item = $this->bus->ask($query);
        $data = $item->getResult()[Result::DATA];

        # Training
        $training = $data['training'];
        $headers = array_keys($training);

        $output->writeln('Training details:');

        $table = new Table($output);
        $table->setHeaders($headers);
        $table->setRows([$training]);

        $table->render();

        # Exercises
        $exercises = $data['exercises'];
        $headers = array_keys($exercises[0]);

        $output->writeln('Exercises:');

        $table = new Table($output);
        $table->setHeaders($headers);
        $table->setRows($exercises);

        $table->render();

        return Command::SUCCESS;
    }
}
