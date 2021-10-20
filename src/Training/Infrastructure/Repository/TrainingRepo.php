<?php

declare(strict_types=1);

namespace App\Training\Infrastructure\Repository;

use App\Training\Domain\Repository\TrainingById;
use App\Training\Domain\Repository\TrainingStore as Store;
use App\Training\Domain\Training;
use App\Training\Domain\TrainingId;
use Doctrine\ORM\EntityManagerInterface;

final class TrainingRepo implements TrainingById, Store
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function findOne(TrainingId $id): ?Training
    {
        return $this->em->getRepository(Training::class)->find($id);
    }

    public function store(Training $training): void
    {
        $this->em->persist($training);
        $this->em->flush();
    }
}
