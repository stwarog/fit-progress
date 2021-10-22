<?php

declare(strict_types=1);

namespace App\Training\Application\Query\GetTrainingDetails;

use App\Shared\Application\Command\CommandHandler;
use App\Shared\Application\Query\Item;
use App\Shared\Domain\Exceptions\NotFoundException;
use App\Training\Infrastructure\ReadModel\Presenter\TrainingDetails;

final class Handler implements CommandHandler
{
    public function __construct(private TrainingDetails $presenter)
    {
    }

    /**
     * @param Query $query
     * @return Item<array>
     */
    public function __invoke(Query $query): Item
    {
        $view = $this->presenter->getResult($query->trainingId);

        if (empty($view)) {
            throw new NotFoundException('Unable to found view for Training = ' . $query->trainingId);
        }

        return new Item($view);
    }
}
