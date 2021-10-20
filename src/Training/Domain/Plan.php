<?php

declare(strict_types=1);

namespace App\Training\Domain;

use Countable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use InvalidArgumentException;

class Plan implements Countable
{
    private string $id;
    private string $name;
    private Collection $exercises;

    public function __construct(PlanId $id, Name $name, array $exercises = [])
    {
        $this->exercises = new ArrayCollection($exercises);

        foreach ($this->exercises as $e) {
            if (!$e instanceof Exercise) {
                throw new InvalidArgumentException(
                    sprintf('Plan accepts only %s, %s given', Exercise::class, get_class($e))
                );
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

    public function getId(): PlanId
    {
        return new PlanId($this->id);
    }
}
