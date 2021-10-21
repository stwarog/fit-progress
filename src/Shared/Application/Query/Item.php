<?php

declare(strict_types=1);

namespace App\Shared\Application\Query;

use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

final class Item implements Result
{
    public function __construct(private JsonSerializable|array $data)
    {
    }

    #[ArrayShape([self::DATA => "mixed"])] public function getResult(): array
    {
        $i = $this->data;
        return [
            self::DATA => is_array($i) ? $i : $i->jsonSerialize()
        ];
    }
}
