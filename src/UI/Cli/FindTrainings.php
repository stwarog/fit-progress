<?php

declare(strict_types=1);

namespace App\UI\Cli;

use App\Application\FindTrainings\Query;
use App\Shared\Application\Query\QueryBus;
use App\Shared\Application\Query\Result;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class FindTrainings extends Command
{
    protected static $defaultName = 'app:training:list';
    protected static $defaultDescription = 'Get list of all trainings from the newest one';

    public function __construct(private QueryBus $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $collection = $this->bus->ask(new Query());
        $data = $collection->getResult()[Result::DATA];
        $headers = array_keys($data[0]);

        $table = new Table($output);
        $table->setHeaders($headers);
        $table->setRows($data);

        $table->render();

        return Command::SUCCESS;
    }
}
