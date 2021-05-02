<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\IntegrationEvent;

use App\Common\Domain\Bus\IntegrationEvent\IntegrationEvent;
use App\Common\Domain\Bus\IntegrationEvent\IntegrationEventBus;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerIntegrationEventBus implements IntegrationEventBus
{
    public function __construct(private MessageBusInterface $integrationEventBus) {}

    public function publish(IntegrationEvent $integrationEvent): void
    {
        $this->integrationEventBus->dispatch($integrationEvent);
    }
}
