<?php

declare(strict_types=1);

namespace Unit;

use App\Exercise;
use App\Plan;
use App\Training;
use App\TrainingId;
use PHPUnit\Framework\TestCase;

/** @covers \App\Training */
final class TrainingTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Training(
            new TrainingId('value'),
            new Plan([new Exercise()])
        );
        $this->assertInstanceOf(Training::class, $sut);
    }
}
