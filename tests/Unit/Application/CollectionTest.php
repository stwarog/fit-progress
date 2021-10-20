<?php

namespace Unit\Application;

use App\Application\Collection;
use App\Application\Result;
use JsonSerializable;
use Unit\TestCase;

/** @covers \App\Application\Collection */
class CollectionTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Collection([]);
        $this->assertInstanceOf(Result::class, $sut);
    }

    public function testGetResultContainsDataFromJsonSerializable(): void
    {
        // Given Collection with Json serializable object
        $sut = new Collection([
            $this->getJsonSerializableObject(['field' => 'value'])
        ]);

        // When executed
        $actual = $sut->getResult();

        // Then body should be as expected
        $expected = [
            'data' => [
                ['field' => 'value']
            ]
        ];

        $this->assertSame($expected, $actual);
    }

    public function testGetResultContainsDataFromArray(): void
    {
        // Given Collection with Json serializable object
        $sut = new Collection([
            ['field' => 'value']
        ]);

        // When executed
        $actual = $sut->getResult();

        // Then body should be as expected
        $expected = [
            'data' => [
                ['field' => 'value']
            ]
        ];

        $this->assertSame($expected, $actual);
    }

    private function getJsonSerializableObject(array $data): JsonSerializable
    {
        return new class($data) implements JsonSerializable {

            public function __construct(private array $data)
            {
            }

            public function jsonSerialize(): array
            {
                return $this->data;
            }
        };
    }
}
