<?php

declare(strict_types=1);

namespace Unit\Training\Infrastructure\Repository;

use App\Domain\Catalog\ExerciseById;
use App\Domain\Catalog\ExerciseId;
use App\Training\Infrastructure\Repository\InMemoryExercise;
use PHPUnit\Framework\TestCase;

/** @covers \App\Training\Infrastructure\Repository\InMemoryExercise */
final class InMemoryExerciseTest extends TestCase
{
    public function testConstructor(): InMemoryExercise
    {
        $sut = new InMemoryExercise();
        $this->assertInstanceOf(ExerciseById::class, $sut);
        return $sut;
    }

    /** @depends testConstructor */
    public function testFindOneNotExistingEntryReturnsNull(InMemoryExercise $sut): void
    {
        $this->assertNull($sut->findOne(new ExerciseId('not existing one')));
    }

    /** @depends testConstructor */
    public function testFindOneExistingEntryReturns(InMemoryExercise $sut): void
    {
        $this->assertNotNull($sut->findOne(new ExerciseId('81ab6910-5222-48b4-bc50-355d40459ac9')));
    }
}
