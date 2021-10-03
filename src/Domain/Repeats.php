<?php

declare(strict_types=1);

namespace App\Domain;

use OutOfBoundsException;

final class Repeats
{
    public function __construct(private int $value)
    {
        if (!in_array($this->value, range(1, 100))) {
            throw new OutOfBoundsException('Repeats value must be in range [1-100]');
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
