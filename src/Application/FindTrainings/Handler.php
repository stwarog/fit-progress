<?php

declare(strict_types=1);

namespace App\Application\FindTrainings;

use App\Application\Collection;
use App\Application\CommandHandler;
use App\Infrastructure\ReadModel\TrainingRepo;
use App\Infrastructure\ReadModel\TrainingView;

final class Handler implements CommandHandler
{
    public function __construct(private TrainingRepo $repo)
    {
    }

    /**
     * @param Query $query
     * @return Collection<TrainingView>
     */
    public function __invoke(Query $query): Collection
    {
        $views = $this->repo->findAll();

        return new Collection($views);
    }
}
