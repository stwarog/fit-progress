<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Plan;
use App\Domain\PlanId;

interface PlanById
{
    public function findOne(PlanId $id): ?Plan;
}
