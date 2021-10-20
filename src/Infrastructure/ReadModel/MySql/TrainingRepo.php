<?php

declare(strict_types=1);

namespace App\Infrastructure\ReadModel\MySql;

use App\Infrastructure\ReadModel\TrainingRepo as ReadModelTrainingRepo;
use App\Infrastructure\ReadModel\TrainingView;
use Doctrine\ORM\EntityManagerInterface;

final class TrainingRepo implements ReadModelTrainingRepo
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    /**
     * @inheritdoc
     */
    public function findAll(): array
    {
        $c = $this->em->getConnection();

        $sql =
            "
            select TRAINING.id, TRAINING.name, TRAINING.plan_id planId,PLAN.name planName,
                   TRAINING.status, TRAINING.date,
           (
           select sum(A.repeats)
           from training_activities A
                    left join join_training_activities TA on A.id = TA.activity_id
           where TA.training_id = TRAINING.id
           group by A.exercise_id
           ) doneRepeats,
           (
               select sum(p.repeats)
               from join_plan_exercises PE
                        left join trainings T on PE.plan_id = T.plan_id     
                        left join plan_exercises p on PE.exercise_id = p.id
               where TRAINING.id = T.id
           ) plannedRepeats,
           (
               select count(TA.exercise_id)
               from training_activities TA
                        left join join_training_activities TA on TA.id = TA.activity_id
               where TA.training_id = TRAINING.id
               group by TA.exercise_id
           ) doneExercises,
           (
               select count(PE.exercise_id)
               from join_plan_exercises PE
                        left join trainings T on PE.plan_id = T.plan_id
               where TRAINING.id = T.id
           ) plannedExercises,
           (
               select sum(TA.weight) * SUM(TA.repeats)
               from training_activities TA
                        left join join_training_activities TA on TA.id = TA.activity_id
               where TA.training_id = TRAINING.id
           ) liftedWeight
    
            from trainings TRAINING
             left join plans PLAN on TRAINING.plan_id = PLAN.id
                order by date desc
            ";

        $e = $c->executeQuery($sql);

        return array_map(fn(array $t) => TrainingView::denormalize($t), $e->fetchAllAssociative());
    }
}
