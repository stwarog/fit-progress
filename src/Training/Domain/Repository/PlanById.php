<?php

declare(strict_types=1);

namespace App\Training\Domain\Repository;

use App\Training\Domain\Plan;
use App\Training\Domain\PlanId;

interface PlanById
{
    public function findOne(PlanId $id): ?Plan;
}
