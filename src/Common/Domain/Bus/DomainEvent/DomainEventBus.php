<?php

namespace App\Common\Domain\Bus\DomainEvent;

interface DomainEventBus
{
    public function dispatch(DomainEvent $domainEvent): void;
}
