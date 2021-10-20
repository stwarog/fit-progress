<?php

declare(strict_types=1);

namespace App\Training\Infrastructure\Repository;

use App\Training\Domain\Catalog\Exercise;
use App\Training\Domain\Catalog\ExerciseById;
use App\Training\Domain\Catalog\ExerciseId;
use App\Training\Domain\Name;
use JetBrains\PhpStorm\Pure;

/**
 * @see https://www.centrumfitness.eu/trening/59-tlumaczenie-angielskich-nazw-cwiczen
 */
final class InMemoryExercise implements ExerciseById
{
    private array $catalog = [];

    #[Pure] public function __construct()
    {
        $names = [
            ['4ef022ee-bd51-405e-b1a6-e23139a3e9d3', 'Barbell Bench Press'],
            ['fe28fe0f-3fe7-4bcf-8a14-ddd2bd60822d', 'Dumbbell Bench Press'],
            ['81ab6910-5222-48b4-bc50-355d40459ac9', 'Incline Bench Press'],
            ['a7041851-d794-4153-a337-db468eefd7b5', 'Reverse Grip Incline Bench Press'],
            ['6eac986a-debe-4e08-8989-7b4fdd94cbf0', 'Incline Dumbbell Bench Press'],
        ];

        foreach ($names as $dataSet) {
            [$id, $name] = $dataSet;
            $this->catalog[$id] = new Exercise(new ExerciseId($id), new Name($name));
        }
    }

    public function findOne(ExerciseId $id): ?Exercise
    {
        return $this->catalog[(string)$id] ?? null;
    }
}
