<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Catalog\Exercise;
use App\Domain\Catalog\ExerciseId;
use Countable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class Plan implements Countable
{
    private string $id;
    private string $name;
    private Collection $exercises;

    public function __construct(PlanId $id, Name $name, array $exercises = [])
    {
        $this->exercises = new ArrayCollection($exercises);

        foreach ($this->exercises as $e) {
            if (!$e instanceof ExerciseId) {
//                throw new InvalidArgumentException(
////                    sprintf('Plan accepts only Exercises, %s given', get_class($e))
//                );
            }
        }
        $this->id = (string)$id;
        $this->name = (string)$name;
    }

    public function add(Exercise $e): void
    {
        $this->exercises[] = $e;
    }

    public function count(): int
    {
        return count($this->exercises);
    }
}
