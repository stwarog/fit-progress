<?php

declare(strict_types=1);

namespace Unit;

use App\ActivityId;
use PHPUnit\Framework\TestCase;

/** @covers \App\ActivityId */
final class ActivityIdTest extends TestCase
{
    public function testConstructor(): ActivityId
    {
        $sut = new ActivityId('some value');
        $this->assertInstanceOf(ActivityId::class, $sut);
        return $sut;
    }

    /** @depends testConstructor */
    public function testToStringReturnsInitialValue(ActivityId $sut): void
    {
        $this->assertSame('some value', (string)$sut);
    }
}
