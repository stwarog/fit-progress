<?php

declare(strict_types=1);

namespace Unit\Domain;

use App\Domain\Name;
use PHPUnit\Framework\TestCase;

/** @covers \App\Domain\Name */
final class NameTest extends TestCase
{
    public function testConstructor(): Name
    {
        $sut = new Name('some value');
        $this->assertInstanceOf(Name::class, $sut);
        return $sut;
    }

    /** @depends testConstructor */
    public function testToStringReturnsInitialValue(Name $sut): void
    {
        $this->assertSame('some value', (string)$sut);
    }
}
