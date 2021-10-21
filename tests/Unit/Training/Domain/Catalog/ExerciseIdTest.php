<?php

declare(strict_types=1);

namespace Unit\Training\Domain\Catalog;

use App\Shared\Domain\AbstractId;
use App\Training\Domain\Catalog\ExerciseId;
use PHPUnit\Framework\TestCase;

/** @covers \App\Training\Domain\Catalog\ExerciseId */
final class ExerciseIdTest extends TestCase
{
    public function testConstructor(): ExerciseId
    {
        $sut = new ExerciseId('some value');
        $this->assertInstanceOf(ExerciseId::class, $sut);
        $this->assertInstanceOf(AbstractId::class, $sut);
        return $sut;
    }

    /** @depends testConstructor */
    public function testToStringReturnsInitialValue(ExerciseId $sut): void
    {
        $this->assertSame('some value', (string)$sut);
    }

    public function testConstructorFromStatic(): void
    {
        $sut = ExerciseId::random();
        $this->assertInstanceOf(ExerciseId::class, $sut);
    }
}
