<?php

declare(strict_types=1);

namespace App\Domain;

use Countable as Countable;

final class Training implements Countable
{
    public function __construct(private TrainingId $id, Date $date, private PlanId $plan)
    {
    }

    public function add(Activity $exercise): void
    {
    }

    public function count(): int
    {
        return 1;
    }
}
