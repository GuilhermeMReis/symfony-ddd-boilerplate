<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\DomainEvent;

use App\Common\Domain\Bus\DomainEvent\DomainEvent;
use App\Common\Domain\Bus\DomainEvent\DomainEventBus;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerDomainEventBus implements DomainEventBus
{
    public function __construct(private MessageBusInterface $commandBus) {}

    public function dispatch(DomainEvent $domainEvent): void
    {
        $this->commandBus->dispatch($domainEvent);
    }
}
