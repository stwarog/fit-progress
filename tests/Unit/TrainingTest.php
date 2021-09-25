<?php

declare(strict_types=1);

namespace Unit;

use App\Date;
use App\Exercise;
use App\Id;
use App\Name;
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
            new Date('2021-09-01'),
            new Plan([new Exercise(new Id('id'), new Name('name'))])
        );
        $this->assertInstanceOf(Training::class, $sut);
    }
}
