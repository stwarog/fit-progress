<?php

declare(strict_types=1);

namespace App\Domain;

use OutOfBoundsException;

final class Weight
{
    private const MIN_KG = 5.0;
    private const MAX_KG = 300.0;

    public function __construct(private float $value)
    {
        if ($value < self::MIN_KG || $value > self::MAX_KG) {
            throw new OutOfBoundsException('Weight value must be in range [5-300]');
        }
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
