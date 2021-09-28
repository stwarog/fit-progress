<?php

declare(strict_types=1);

namespace App;

use OutOfBoundsException;

final class Repeats
{
    public function __construct(private int $value)
    {
        if (!in_array($this->value, range(1, 100))) {
            throw new OutOfBoundsException('Repeats value must be in range [1-100]');
        }
    }
}
