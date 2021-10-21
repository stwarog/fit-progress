<?php

declare(strict_types=1);

namespace App\Training\Application\Query\FindTrainings;

use App\Shared\Application\Command\CommandHandler;
use App\Shared\Application\Query\Collection;
use App\Training\Infrastructure\ReadModel\Training;
use App\Training\Infrastructure\ReadModel\TrainingRepo;

final class Handler implements CommandHandler
{
    public function __construct(private TrainingRepo $repo)
    {
    }

    /**
     * @param Query $query
     * @return Collection<Training>
     */
    public function __invoke(Query $query): Collection
    {
        $views = $this->repo->findAll();

        return new Collection($views);
    }
}
