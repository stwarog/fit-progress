<?php

declare(strict_types=1);

namespace Unit\Training\Infrastructure\ReadModel;

use App\Shared\Infrastructure\ReadModel\View;
use App\Training\Domain\Repeats;
use App\Training\Domain\Weight;
use App\Training\Infrastructure\ReadModel\Exercise;
use JsonSerializable;
use Unit\TestCase;

/** @covers \App\Training\Infrastructure\ReadModel\Exercise */
final class ExerciseTest extends TestCase
{
    public function testConstructor(): Exercise
    {
        // Given
        // When new instance is created
        $sut = new Exercise(
            new Weight(20),
            new Repeats(15),
            null
        );

        // Then
        $this->assertInstanceOf(JsonSerializable::class, $sut);
        $this->assertInstanceOf(View::class, $sut);

        return $sut;
    }

    /** @depends testConstructor */
    public function testSerializeAndDeserialize(Exercise $sut): void
    {
        $serialize = serialize($sut);
        $normalize = unserialize($serialize);
        $this->assertEquals($sut, $normalize);
    }

    /** @depends testConstructor */
    public function testDenormalize(Exercise $sut): void
    {
        $normalized = $sut->normalize();
        $this->assertEquals($sut, Exercise::denormalize($normalized));
    }
}
