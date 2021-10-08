<?php

declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;

final class Status
{
    public const PLANNED = 'planned';
    public const STARTED = 'started';
    public const ENDED = 'ended';
    public const SKIPPED = 'skipped';

    public function __construct(private string $value)
    {
        if (
            !in_array($this->value, [
                self::PLANNED,
                self::STARTED,
                self::ENDED,
                self::SKIPPED,
            ])
        ) {
            throw new InvalidArgumentException('Invalid status');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
