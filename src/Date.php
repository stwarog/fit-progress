<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

final class Date
{
    public function __construct(private string $value)
    {
        $chunks = explode('-', $this->value);
        $length = [4, 2, 2];
        for ($c = 0; $c !== count($length); $c++) {
            if (strlen($chunks[$c]) !== $length[$c]) {
                throw new InvalidArgumentException('Invalid date format, only YYYY-mm-dd supported');
            }
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
