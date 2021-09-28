<?php

declare(strict_types=1);

namespace Unit\Catalog;

use App\Catalog\ExerciseId;
use App\Shared\AbstractId;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\ExerciseId */
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
