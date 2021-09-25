<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

final class Plan
{
    public function __construct(private Name $name, private array $exercises)
    {
        if (empty($this->exercises)) {
            throw new InvalidArgumentException('Missing exercises in plan');
        }
        foreach ($this->exercises as $e) {
            if (!$e instanceof Exercise) {
                throw new InvalidArgumentException(
                    sprintf('Plan accepts only Exercises, %s given', get_class($e))
                );
            }
        }
    }
}
