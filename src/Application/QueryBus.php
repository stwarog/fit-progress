<?php

declare(strict_types=1);

namespace App\Application;

interface QueryBus
{
    public function ask(Query $query): mixed;
}