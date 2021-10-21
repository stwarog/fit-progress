<?php

declare(strict_types=1);

namespace Unit;

use App\Training\Domain\Activity;
use App\Training\Domain\ActivityId;
use App\Training\Domain\Catalog\Exercise;
use App\Training\Domain\Catalog\ExerciseById;
use App\Training\Domain\Catalog\ExerciseId;
use App\Training\Domain\Exercise as PlanExercise;
use App\Training\Domain\Name;
use App\Training\Domain\Plan;
use App\Training\Domain\PlanId;
use App\Training\Domain\Repeats;
use App\Training\Domain\Repository\PlanById;
use App\Training\Domain\Weight;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function planByIdStub(bool $returnNull = false): PlanById
    {
        return new class ($this->getExerciseStub(), $returnNull) implements PlanById {

            public function __construct(private PlanExercise $stub, private bool $returnNull = false)
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
                        $this->stub
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
            new Weight(20),
            new Repeats(10),
            ExerciseId::random(),
            $this->exerciseByIdStub(false)
        );
    }

    protected function getExerciseStub(): PlanExercise
    {
        return new PlanExercise(
            \App\Training\Domain\ExerciseId::random(),
            new Weight(20),
            new Repeats(10),
            ExerciseId::random(),
            $this->exerciseByIdStub()
        );
    }
}
