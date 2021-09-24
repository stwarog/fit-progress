<?php

declare(strict_types=1);

namespace App;

final class TrainingId
{
    public function __construct(private string $value)
    {
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
