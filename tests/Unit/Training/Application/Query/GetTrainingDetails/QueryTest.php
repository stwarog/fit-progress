<?php

declare(strict_types=1);

namespace Unit\Training\Application\Query\GetTrainingDetails;

use App\Shared\Application\Query\Query as QueryMarker;
use App\Training\Application\Query\GetTrainingDetails\Query;
use Unit\TestCase;

/** @covers \App\Training\Application\Query\GetTrainingDetails\Query */
final class QueryTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Query('training-id');
        $this->assertInstanceOf(QueryMarker::class, $sut);
    }
}
