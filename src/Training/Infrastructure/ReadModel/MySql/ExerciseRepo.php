<?php

declare(strict_types=1);

namespace App\Training\Infrastructure\ReadModel\MySql;

use App\Training\Domain\TrainingId;
use App\Training\Infrastructure\ReadModel\Exercise;
use App\Training\Infrastructure\ReadModel\ExerciseRepo as ExerciseReadModelRepo;
use Doctrine\ORM\EntityManagerInterface;

final class ExerciseRepo implements ExerciseReadModelRepo
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    /** @inheritdoc */
    public function findAll(TrainingId $trainingId): array
    {
        $c = $this->em->getConnection();

        $id = (string)$trainingId;

        $sql =
            "
            select PE.weight, PE.repeats, PE.exercise_id exerciseId, PE.position
            from plan_exercises PE
            left join join_plan_exercises jpe on PE.id = jpe.exercise_id
            left join trainings T on jpe.plan_id = T.plan_id
            where T.id = $id
            order by PE.position;
            ";

        $e = $c->executeQuery($sql);

        return array_map(fn(array $e) => Exercise::denormalize($e), $e->fetchAllAssociative());
    }
}
