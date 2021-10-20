<?php

declare(strict_types=1);

namespace Unit\Training\Domain;

use App\Training\Domain\Status;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/** @covers \App\Domain\Status */
final class StatusTest extends TestCase
{
    public function testConstructor(): Status
    {
        $sut = new Status('planned');
        $this->assertInstanceOf(Status::class, $sut);
        return $sut;
    }

    /** @depends testConstructor */
    public function testToStringReturnsInitialValue(Status $sut): void
    {
        $this->assertSame('planned', (string)$sut);
    }

    public function testConstructorInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid status');

        new Status('some value');
    }
}
