<?php

declare(strict_types=1);

namespace Unit\Training\Application\Query\FindTrainings;

use App\Domain\Date;
use App\Domain\Name;
use App\Domain\Status;
use App\Domain\TrainingId;
use App\Shared\Application\Query\Collection;
use App\Training\Application\Query\FindTrainings\Handler;
use App\Training\Application\Query\FindTrainings\Query;
use App\Training\Infrastructure\ReadModel\TrainingRepo;
use App\Training\Infrastructure\ReadModel\TrainingView;
use Unit\TestCase;

/** @covers \App\Training\Application\Query\FindTrainings\Handler */
final class HandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        // Given Query
        $query = new Query();

        // And handler
        $repo = $this->createMock(TrainingRepo::class);
        $repo->method('findAll')->willReturn([
            new TrainingView(
                new TrainingId('9561-6309-3822-4534'),
                new Name('FBW'),
                new Status(Status::PLANNED),
                new Date('2021-10-13'),
            )
        ]);

        $sut = new Handler($repo);

        // And expected output
        $expected = [
            'data' => [
                [
                    "id" => "9561-6309-3822-4534",
                    "name" => "FBW",
                    "status" => "planned",
                    "date" => "2021-10-13",
                    "planId" => null,
                    "planName" => null,
                    "doneRepeats" => 0,
                    "plannedRepeats" => 0,
                    "doneExercises" => 0,
                    "plannedExercises" => 0,
                    "liftedWeight" => 0.0,
                ]
            ]
        ];

        // When called
        $collection = $sut($query);

        // Then collection should be returned
        $this->assertInstanceOf(Collection::class, $collection);
        $actual = $collection->getResult();
        $this->assertSame($expected, $actual);
    }
}
