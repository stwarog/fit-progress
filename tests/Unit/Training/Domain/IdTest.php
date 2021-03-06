<?php

declare(strict_types=1);

namespace Unit\Training\Domain;

use App\Shared\Domain\AbstractId;
use App\Training\Domain\Id;
use PHPUnit\Framework\TestCase;

/** @covers \App\Training\Domain\Id */
final class IdTest extends TestCase
{
    public function testConstructor(): Id
    {
        $sut = new Id('some value');
        $this->assertInstanceOf(Id::class, $sut);
        $this->assertInstanceOf(AbstractId::class, $sut);
        return $sut;
    }

    /** @depends testConstructor */
    public function testToStringReturnsInitialValue(Id $sut): void
    {
        $this->assertSame('some value', (string)$sut);
    }

    public function testConstructorFromStatic(): Id
    {
        $sut = Id::random();
        $this->assertInstanceOf(Id::class, $sut);
        return $sut;
    }
}
