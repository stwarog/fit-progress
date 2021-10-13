<?php

declare(strict_types=1);

namespace App\Domain;

use OutOfBoundsException;

final class Weight
{
    private const MIN_KG = 0.0;
    private const MAX_KG = 10000.0;

    public function __construct(private float $value)
    {
        if ($value < self::MIN_KG || $value > self::MAX_KG) {
            throw new OutOfBoundsException(
                sprintf(
                    'Weight value must be in range [%d-%d], actual value is [%f]',
                    self::MIN_KG,
                    self::MAX_KG,
                    $this->value
                )
            );
        }
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
