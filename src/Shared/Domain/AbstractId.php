<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use Ramsey\Uuid\Uuid;

abstract class AbstractId
{
    public function __construct(private string $value)
    {
    }

    /** @return static */
    public static function random(): self
    {
        $uuid = Uuid::uuid4()->toString();
        $parent = get_called_class();
        return new $parent($uuid);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
