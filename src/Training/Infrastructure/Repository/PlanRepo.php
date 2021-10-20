<?php

declare(strict_types=1);

namespace App\Training\Infrastructure\Repository;

use App\Training\Domain\Plan;
use App\Training\Domain\PlanId;
use App\Training\Domain\Repository\PlanById;
use App\Training\Domain\Repository\PlanStore as Store;
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
