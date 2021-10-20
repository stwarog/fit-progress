<?php

namespace App\Shared\Application\Query;

interface Result
{
    public const DATA = 'data';

    public function getResult(): array;
}
