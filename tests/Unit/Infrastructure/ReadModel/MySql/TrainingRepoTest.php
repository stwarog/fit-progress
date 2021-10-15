<?php

declare(strict_types=1);

namespace Unit\Infrastructure\ReadModel\MySql;

use App\Infrastructure\ReadModel\MySql\TrainingRepo;
use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\Portability\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Unit\TestCase;

/** @covers \App\Infrastructure\ReadModel\MySql\TrainingRepo */
final class TrainingRepoTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new TrainingRepo($this->createMock(EntityManagerInterface::class));
        $this->assertInstanceOf(\App\Infrastructure\ReadModel\TrainingRepo::class, $sut);
    }

    public function testFindAll(): void
    {
        // Given data returned by Entity Manager
        $fetchedData = [
            [
                "id" => "7782-2661-3884-9811",
                "name" => "FBW1",
                "planId" => "plan-id",
                "planName" => "super plan!",
                "status" => "started",
                "date" => "2021-10-11",
                "doneRepeats" => "2",
                "plannedRepeats" => "1",
                "doneExercises" => "1",
                "plannedExercises" => "1",
                "liftedWeight" => "3900.0",
            ],
            [
                "id" => "7782-2661-3884-9811",
                "name" => "FBW1",
                "planId" => null,
                "planName" => null,
                "status" => "started",
                "date" => "2021-10-15",
                "doneRepeats" => "12",
                "plannedRepeats" => "10",
                "doneExercises" => "1",
                "plannedExercises" => "15",
                "liftedWeight" => "3900",
            ],
        ];
        $connection = $this->stubConnection($fetchedData);

        $em = $this->createMock(EntityManagerInterface::class);
        $em->method('getConnection')->willReturn($connection);

        // And View repository
        $sut = new TrainingRepo($em);

        // When
        $result = $sut->findAll();

        // Then result's should be valid fetched data mapped
        for ($c = 0; $c !== count($fetchedData); $c++) {
            $actual = $result[$c];
            $expected = $fetchedData[$c];
            $this->assertSame($expected['id'], $actual->id);
            $this->assertSame($expected['name'], $actual->name);
            $this->assertSame($expected['planId'], $actual->planId);
            $this->assertSame($expected['planName'], $actual->planName);
            $this->assertSame($expected['status'], $actual->status);
            $this->assertSame($expected['date'], $actual->date);
            $this->assertEquals($expected['doneRepeats'], $actual->doneRepeats);
            $this->assertEquals($expected['plannedRepeats'], $actual->plannedRepeats);
            $this->assertEquals($expected['doneExercises'], $actual->doneExercises);
            $this->assertEquals($expected['plannedExercises'], $actual->plannedExercises);
            $this->assertEquals($expected['liftedWeight'], $actual->liftedWeight);
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
