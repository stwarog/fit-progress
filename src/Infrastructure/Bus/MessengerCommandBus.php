<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus;

use App\Application\Command;
use App\Application\CommandBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class MessengerCommandBus implements CommandBus
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /** @throws Throwable */
    public function handle(Command $command): void
    {
        $this->messageBus->dispatch($command);
    }
}
