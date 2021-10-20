<?php

declare(strict_types=1);

namespace Unit\Training\Application\Command\CreatePlan;

use App\Training\Application\Command\CreatePlan\Command;
use PHPUnit\Framework\TestCase;

/** @covers \App\Training\Application\Command\CreatePlan\Command */
final class CommandTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new Command('name');
        $this->assertInstanceOf(Command::class, $sut);

        $this->assertEquals('name', $sut->name);
    }

    public function testCreateWithExercises(): void
    {
        // Given & When command created with Exercises as array
        $sut = new Command('name', [
            [20.0, 15, '4ef022ee-bd51-405e-b1a6-e23139a3e9d3'],
            [25.0, 3, '4ef022ee-bd51-405e-b1a6-e23139a3e9d3'],
        ]);

        // Then
        $expected = [
            [
                'weight' => 20.0,
                'repeats' => 15,
                'exercise_id' => '4ef022ee-bd51-405e-b1a6-e23139a3e9d3',
            ],
            [
                'weight' => 25.0,
                'repeats' => 3,
                'exercise_id' => '4ef022ee-bd51-405e-b1a6-e23139a3e9d3',
            ],
        ];
        $this->assertSame($expected, $sut->exercises);
        $this->assertEquals('name', $sut->name);
    }
}
