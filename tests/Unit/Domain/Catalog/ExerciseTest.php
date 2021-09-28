<?php

declare(strict_types=1);

namespace Unit\Domain\Catalog;

use App\Domain\Catalog\Exercise;
use App\Domain\Catalog\ExerciseId;
use App\Domain\Name;
use PHPUnit\Framework\TestCase;

/** @covers \App\Domain\Catalog\Exercise */
final class ExerciseTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Exercise(new ExerciseId('id'), new Name('name'));
        $this->assertInstanceOf(Exercise::class, $sut);
    }
}
