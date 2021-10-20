<?php

declare(strict_types=1);

namespace App\Training\Infrastructure\Repository;

use App\Domain\Plan;
use App\Domain\PlanId;
use App\Domain\Repository\PlanById;
use App\Domain\Repository\PlanStore as Store;
use Doctrine\ORM\EntityManagerInterface;

final class PlanRepo implements Store, PlanById
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function store(Plan $plan): void
    {
        $this->em->persist($plan);
        $this->em->flush();
    }

    public function findOne(PlanId $id): ?Plan
    {
        return $this->em->getRepository(Plan::class)->find($id);
    }
}
