<?php

namespace App\Common\Domain\Bus\IntegrationEvent;

interface IntegrationEventBus
{
    public function publish(IntegrationEvent $integrationEvent): void;
}
