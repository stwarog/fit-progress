<?php

declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;

final class DateTime
{
    private const FORMAT = 'Y-m-d H:i:s';

    public function __construct(private string $value)
    {
        [$date, $time] = explode(' ', $this->value);

        # Check date
        $chunks = explode('-', $date);
        $length = [4, 2, 2];
        for ($c = 0; $c !== count($length); $c++) {
            if (strlen($chunks[$c]) !== $length[$c]) {
                throw new InvalidArgumentException(
                    sprintf('Invalid date time format, only %s supported', self::FORMAT)
                );
            }
        }

        # Check time
        if (strlen($time) !== 8) {
            throw new InvalidArgumentException(
                sprintf('Invalid date time format, only %s supported', self::FORMAT)
            );
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
