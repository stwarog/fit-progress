<?php

declare(strict_types=1);

namespace Unit\Domain;

use App\Domain\Repeats;
use Generator;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Domain\Repeats */
final class RepeatsTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Repeats(1);
        $this->assertInstanceOf(Repeats::class, $sut);
    }

    /** @dataProvider provideConstructorValueOutOf1To100RangeThrowsError */
    public function testConstructorValueOutOf1To100RangeThrowsError(int $value): void
    {
        // Expect
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Repeats value must be in range [1-100]');

        // Given Repeats with value
        $sut = new Repeats($value);
    }

    public function provideConstructorValueOutOf1To100RangeThrowsError(): Generator
    {
        yield '-1' => [-1];
        yield '11' => [101];
    }
}
