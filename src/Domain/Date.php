<?php

declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;

final class Date
{
    private const FORMAT = 'Y-m-d';

    public function __construct(private string $value)
    {
        $chunks = explode('-', $this->value);
        $length = [4, 2, 2];
        for ($c = 0; $c !== count($length); $c++) {
            if (strlen($chunks[$c]) !== $length[$c]) {
                throw new InvalidArgumentException(
                    sprintf('Invalid date format, only %s supported', self::FORMAT)
                );
            }
        }
    }

    /** @return static */
    public static function now(): self
    {
        return new self(date(self::FORMAT));
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
