<?php

namespace Unit\Shared\Application\Query;

use App\Shared\Application\Query\Item;
use App\Shared\Application\Query\Result;
use JsonSerializable;
use Unit\TestCase;

/** @covers \App\Shared\Application\Query\Item */
class ItemTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Item([]);
        $this->assertInstanceOf(Result::class, $sut);
    }

    public function testGetResultContainsDataFromJsonSerializable(): void
    {
        // Given Item with Json serializable object
        $sut = new Item($this->getJsonSerializableObject(['field' => 'value']));

        // When executed
        $actual = $sut->getResult();

        // Then body should be as expected
        $expected = [
            'data' => ['field' => 'value']
        ];

        $this->assertSame($expected, $actual);
    }

    public function testGetResultContainsDataFromArray(): void
    {
        // Given Item with Json serializable object
        $sut = new Item(['field' => 'value']);

        // When executed
        $actual = $sut->getResult();

        // Then body should be as expected
        $expected = [
            'data' => ['field' => 'value']
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
