<?php

declare(strict_types=1);

namespace App\Training\Domain;

use OutOfBoundsException;

final class Round
{
    public function __construct(private int $value)
    {
        if (!in_array($this->value, range(1, 10))) {
            throw new OutOfBoundsException('Round value must be in range [1-10]');
        }
    }
}
