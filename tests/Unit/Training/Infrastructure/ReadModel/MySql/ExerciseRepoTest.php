<?php

declare(strict_types=1);

namespace Unit\Training\Infrastructure\ReadModel\MySql;

use App\Training\Domain\TrainingId;
use App\Training\Infrastructure\ReadModel\MySql\ExerciseRepo;
use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\Portability\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Unit\TestCase;

/** @covers \App\Training\Infrastructure\ReadModel\MySql\ExerciseRepo */
final class ExerciseRepoTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new ExerciseRepo($this->createMock(EntityManagerInterface::class));
        $this->assertInstanceOf(\App\Training\Infrastructure\ReadModel\ExerciseRepo::class, $sut);
    }

    public function testFindAll(): void
    {
        // Given data returned by Entity Manager
        $trainingId = TrainingId::random();

        $fetchedData = [
            [
                "weight" => "10.5",
                "repeats" => "20",
                "exerciseId" => "exercise-id",
            ],
            [
                "weight" => "15.5",
                "repeats" => "10",
                "exerciseId" => "exercise-id-2",
            ],
        ];
        $connection = $this->stubConnection($fetchedData);

        $em = $this->createMock(EntityManagerInterface::class);
        $em->method('getConnection')->willReturn($connection);

        // And View repository
        $sut = new ExerciseRepo($em);

        // When
        $result = $sut->findAll($trainingId);

        // Then result's should be valid fetched data mapped
        for ($c = 0; $c !== count($fetchedData); $c++) {
            $actual = $result[$c];
            $expected = $fetchedData[$c];
            $this->assertEquals($expected['repeats'], $actual->repeats);
            $this->assertEquals($expected['weight'], $actual->weight);
            $this->assertSame($expected['exerciseId'], $actual->exerciseId);
        }
    }

    private function stubConnection(array $fetchAllAssociative): Connection
    {
        $connection = $this->createMock(Connection::class);
        $result = $this->createMock(Result::class);
        $result->method('fetchAllAssociative')->willReturn($fetchAllAssociative);
        $connection->method('executeQuery')->willReturn($result);
        return $connection;
    }
}
