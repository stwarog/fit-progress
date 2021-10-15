<?php

declare(strict_types=1);

namespace App\Application;

use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

final class Collection implements Result
{
    /** @param array<JsonSerializable|array> $data */
    public function __construct(private array $data)
    {
    }

    #[ArrayShape([self::DATA => "array"])] public function getResult(): array
    {
        return [
            self::DATA => array_map(
                function (JsonSerializable|array $i) {
                    return is_array($i) ? $i : $i->jsonSerialize();
                },
                $this->data
            )
        ];
    }
}
