<?php

declare(strict_types=1);

namespace Unit\Catalog;

use App\Catalog\Exercise;
use App\Catalog\ExerciseId;
use App\Name;
use PHPUnit\Framework\TestCase;

/** @covers \App\Catalog\Exercise */
final class ExerciseTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Exercise(new ExerciseId('id'), new Name('name'));
        $this->assertInstanceOf(Exercise::class, $sut);
    }
}
