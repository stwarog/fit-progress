<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Plan;
use App\Domain\Repository\PlanStore as Store;
use Doctrine\ORM\EntityManagerInterface;

final class PlanRepo implements Store
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function store(Plan $plan): void
    {
        $this->em->persist($plan);
        $this->em->flush();
    }
}
