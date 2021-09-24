<?php

declare(strict_types=1);

namespace Unit;

use App\Training;
use PHPUnit\Framework\TestCase;

/** @covers \App\Training */
final class TrainingTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Training();
        $this->assertInstanceOf(Training::class, $sut);
    }
}
