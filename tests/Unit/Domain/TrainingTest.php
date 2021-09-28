<?php

declare(strict_types=1);

namespace Unit\Domain;

use App\Domain\Date;
use App\Domain\PlanId;
use App\Domain\Training;
use App\Domain\TrainingId;
use PHPUnit\Framework\TestCase;

/** @covers \App\Domain\Training */
final class TrainingTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Training(
            new TrainingId('value'),
            new Date('2021-09-01'),
            PlanId::random()
        );
        $this->assertInstanceOf(Training::class, $sut);
    }
}
