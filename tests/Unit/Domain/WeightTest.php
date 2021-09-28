<?php

declare(strict_types=1);

namespace Unit\Domain;

use App\Domain\Weight;
use Generator;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Domain\Weight */
final class WeightTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Weight(5.5);
        $this->assertInstanceOf(Weight::class, $sut);
    }

    /** @dataProvider provideConstructorValueOutOf5To300RangeThrowsError */
    public function testConstructorValueOutOf5To300RangeThrowsError(float $value): void
    {
        // Expect
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Weight value must be in range [5-300]');

        // Given Weight with value
        $sut = new Weight($value);
    }

    public function provideConstructorValueOutOf5To300RangeThrowsError(): Generator
    {
        yield '-1' => [-1.0];
        yield '300.5' => [300.5];
    }
}