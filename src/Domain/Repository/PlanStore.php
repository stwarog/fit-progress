<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Plan;

interface PlanStore
{
    public function store(Plan $plan): void;
}
