<?php

declare(strict_types=1);

namespace App\Training\Domain\Repository;

use App\Training\Domain\Plan;

interface PlanStore
{
    public function store(Plan $plan): void;
}
