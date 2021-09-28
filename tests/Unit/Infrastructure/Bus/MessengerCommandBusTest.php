<?php

declare(strict_types=1);

namespace Unit\Infrastructure\Bus;

use App\Application\CommandBus;
use App\Infrastructure\Bus\MessengerCommandBus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\MessageBusInterface;

/** @covers \App\Infrastructure\Bus\MessengerCommandBus */
final class MessengerCommandBusTest extends TestCase
{
    public function testConstructor(): void
    {
        $sut = new MessengerCommandBus($this->createMock(MessageBusInterface::class));
        $this->assertInstanceOf(CommandBus::class, $sut);
    }
}
