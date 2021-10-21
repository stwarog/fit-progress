<?php

declare(strict_types=1);

namespace Unit\Training\Domain;

use App\Training\Domain\Date;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Training\Domain\Date */
final class DateTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Date('2021-01-01');
        $this->assertInstanceOf(Date::class, $sut);
    }

    /** @dataProvider provideConstructorInvalidFormat */
    public function testConstructorInvalidFormat(string $wrongFormat): void
    {
        // Expect
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid date format, only Y-m-d supported');

        // When invalid date provided as argument
        $sut = new Date($wrongFormat);
    }

    public function provideConstructorInvalidFormat(): Generator
    {
        yield 'dd-mm-YYYY' => ['01-01-2021'];
        yield 'dd-mm-YYYY-random' => ['01-01-2021-random'];
        yield 'dd-mm-YY' => ['01-01-20'];
    }

    public function testConstructorNow(): void
    {
        $sut = Date::now();
        $this->assertInstanceOf(Date::class, $sut);
    }
}
