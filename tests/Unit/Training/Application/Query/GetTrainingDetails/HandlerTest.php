<?php

declare(strict_types=1);

namespace Unit\Training\Application\Query\GetTrainingDetails;

use App\Shared\Domain\Exceptions\NotFoundException;
use App\Training\Application\Query\GetTrainingDetails\Handler;
use App\Training\Application\Query\GetTrainingDetails\Query;
use App\Training\Infrastructure\ReadModel\Presenter\TrainingDetails as Presenter;
use Unit\TestCase;

/** @covers \App\Training\Application\Query\GetTrainingDetails\Handler */
final class HandlerTest extends TestCase
{
    public function testConstructor(): Handler
    {
        $sut = new Handler($this->createMock(Presenter::class));
        $this->assertInstanceOf(Handler::class, $sut);

        return $sut;
    }

    /** @depends testConstructor */
    public function testThrowsExceptionOnNotFoundView(Handler $sut): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Unable to found view for Training = training-id');

        $sut(new Query('training-id'));
    }

    public function testReturnsExpectedView(): void
    {
        // Given presenter
        $presenter = $this->createMock(Presenter::class);
        $presenter->method('getResult')->willReturn(['any' => 'array']);

        // And Query & Handler
        $query = new Query('training-id');
        $sut = new Handler($presenter);

        // When invoked
        $result = $sut($query);

        // Then result should be as expected
        $expected = [
            'data' => [
                'any' => 'array'
            ]
        ];
        $actual = $result->getResult();

        $this->assertSame($expected, $actual);
    }
}
