<?php

namespace App\Shared\Infrastructure\ReadModel;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;

interface View extends JsonSerializable
{
    #[Pure] public function normalize(): array;

    #[Pure] public static function denormalize(array $data): JsonSerializable;
}
