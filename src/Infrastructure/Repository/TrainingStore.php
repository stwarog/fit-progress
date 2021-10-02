<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Repository\TrainingStore as Store;
use App\Domain\Training;
use Doctrine\ORM\EntityManagerInterface;

final class TrainingStore implements Store
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function store(Training $training): void
    {
        $this->em->persist($training);
        $this->em->flush();
    }
}
