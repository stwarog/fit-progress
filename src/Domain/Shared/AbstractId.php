<?php

declare(strict_types=1);

namespace App\Domain\Shared;

abstract class AbstractId
{
    public function __construct(private string $value)
    {
    }

    /** @return static */
    public static function random(): self
    {
        $r = fn() => rand(1000, 9999);
        $parent = get_called_class();
        return new $parent(sprintf('%d-%d-%d-%d', $r(), $r(), $r(), $r()));
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
