<?php

declare(strict_types=1);

namespace Unit\Domain;

use App\Domain\Round;
use Generator;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Domain\Round */
final class RoundTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Round(1);
        $this->assertInstanceOf(Round::class, $sut);
    }

    /** @dataProvider provideConstructorValueOutOf1To10RangeThrowsError */
    public function testConstructorValueOutOf1To10RangeThrowsError(int $value): void
    {
        // Expect
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Round value must be in range [1-10]');

        // Given Round with value
        $sut = new Round($value);
    }

    public function provideConstructorValueOutOf1To10RangeThrowsError(): Generator
    {
        yield '-1' => [-1];
        yield '11' => [11];
    }
}
