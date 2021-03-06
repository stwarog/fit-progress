<?php

declare(strict_types=1);

namespace Unit\Training\Domain;

use App\Training\Domain\TrainingId;
use PHPUnit\Framework\TestCase;

/** @covers \App\Training\Domain\TrainingId */
final class TrainingIdTest extends TestCase
{
    public function testConstructor(): TrainingId
    {
        $sut = new TrainingId('some value');
        $this->assertInstanceOf(TrainingId::class, $sut);
        return $sut;
    }

    /** @depends testConstructor */
    public function testToStringReturnsInitialValue(TrainingId $sut): void
    {
        $this->assertSame('some value', (string)$sut);
    }
}
