<?php

declare(strict_types=1);

namespace Unit\Training\Domain\Catalog;

use App\Training\Domain\Catalog\Exercise;
use App\Training\Domain\Catalog\ExerciseId;
use App\Training\Domain\Name;
use PHPUnit\Framework\TestCase;

/** @covers \App\Training\Domain\Catalog\Exercise */
final class ExerciseTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Exercise(new ExerciseId('id'), new Name('name'));
        $this->assertInstanceOf(Exercise::class, $sut);
    }
}
