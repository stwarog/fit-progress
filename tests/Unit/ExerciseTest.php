<?php

declare(strict_types=1);

namespace Unit;

use App\Exercise;
use App\Id;
use App\Name;
use PHPUnit\Framework\TestCase;

/** @covers \App\Exercise */
final class ExerciseTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Exercise(new Id('id'), new Name('name'));
        $this->assertInstanceOf(Exercise::class, $sut);
    }
}
