<?php

declare(strict_types=1);

namespace Unit\Training\Domain;

use App\Training\Domain\Weight;
use Generator;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Training\Domain\Weight */
final class WeightTest extends TestCase
{
    public function testConstructor(): Weight
    {
        $sut = new Weight(5.5);
        $this->assertInstanceOf(Weight::class, $sut);
        return $sut;
    }

    /** @depends testConstructor */
    public function testShouldBeStringCastable(Weight $sut): void
    {
        $this->assertSame('5.5', (string)$sut);
    }

    /** @dataProvider provideConstructorValueOutOf5To300RangeThrowsError */
    public function testConstructorValueOutOf0To10000RangeThrowsError(float $value): void
    {
        // Expect
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Weight value must be in range [0-10000], actual value is');

        // Given Weight with value
        $sut = new Weight($value);
    }

    public function provideConstructorValueOutOf5To300RangeThrowsError(): Generator
    {
        yield '-1' => [-1.0];
        yield '10000.5' => [10000.5];
    }
}
