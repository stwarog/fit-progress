<?php

declare(strict_types=1);

namespace Unit;

use App\Domain\Activity;
use App\Domain\ActivityId;
use App\Domain\Catalog\Exercise;
use App\Domain\Catalog\ExerciseId;
use App\Domain\Name;
use App\Domain\Plan;
use App\Domain\PlanId;
use App\Domain\Repeats;
use App\Domain\Repository\ExerciseById;
use App\Domain\Repository\PlanById;
use App\Domain\TrainingId;
use App\Domain\Weight;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function planByIdStub(bool $returnNull = false): PlanById
    {
        return new class ($returnNull) implements PlanById {

            public function __construct(private bool $returnNull = false)
            {
            }

            public function findOne(PlanId $id): ?Plan
            {
                if ($this->returnNull) {
                    return null;
                }
                return new Plan(
                    PlanId::random(),
                    new Name('FBW'),
                    [
                        ExerciseId::random()
                    ]
                );
            }
        };
    }

    protected function exerciseByIdStub(bool $returnNull = false): ExerciseById
    {
        return new class ($returnNull) implements ExerciseById {

            public function __construct(private bool $returnNull)
            {
            }

            public function findOne(ExerciseId $id): ?Exercise
            {
                if ($this->returnNull) {
                    return null;
                }
                return new Exercise(
                    ExerciseId::random(),
                    new Name('Push ups')
                );
            }
        };
    }

    protected function getActivityStub(): Activity
    {
        return new Activity(
            ActivityId::random(),
            TrainingId::random(),
            new Weight(20),
            new Repeats(10),
            ExerciseId::random(),
            $this->exerciseByIdStub(false)
        );
    }
}
