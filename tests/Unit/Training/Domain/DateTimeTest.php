<?php

declare(strict_types=1);

namespace Unit\Training\Domain;

use App\Training\Domain\DateTime;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Training\Domain\DateTime */
final class DateTimeTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new DateTime('2021-01-01 22:13:10');
        $this->assertInstanceOf(DateTime::class, $sut);
    }

    /** @dataProvider provideConstructorInvalidFormat */
    public function testConstructorInvalidFormat(string $wrongFormat): void
    {
        // Expect
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid date time format, only Y-m-d H:i:s supported');

        // When invalid DateTime provided as argument
        $sut = new DateTime($wrongFormat);
    }

    public function provideConstructorInvalidFormat(): Generator
    {
        yield 'dd-mm-YYYY' => ['01-01-2021 00:13'];
        yield 'dd-mm-YYYY-random' => ['01-01-2021 random'];
        yield 'dd-mm-YY' => ['01-01-20 aa:00:15'];
    }

    public function testConstructorNow(): void
    {
        $sut = DateTime::now();
        $this->assertInstanceOf(DateTime::class, $sut);
    }
}
