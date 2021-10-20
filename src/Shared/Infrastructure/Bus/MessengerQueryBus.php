<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Application\Query\Query;
use App\Shared\Application\Query\QueryBus;
use App\Shared\Application\Query\Result;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

final class MessengerQueryBus implements QueryBus
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /** @throws Throwable */
    public function ask(Query $query): Result
    {
        $envelope = $this->messageBus->dispatch($query);

        /** @var HandledStamp $stamp */
        $stamp = $envelope->last(HandledStamp::class);

        return $stamp->getResult();
    }
}
