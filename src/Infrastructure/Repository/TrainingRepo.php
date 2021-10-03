<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Repository\TrainingById;
use App\Domain\Training;
use App\Domain\TrainingId;
use Doctrine\ORM\EntityManagerInterface;

final class TrainingRepo implements TrainingById
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function findOne(TrainingId $id): ?Training
    {
        return $this->em->getRepository(Training::class)->find($id);
    }
}
