<?php

namespace App\Application;

interface Result
{
    public const DATA = 'data';

    public function getResult(): array;
}
