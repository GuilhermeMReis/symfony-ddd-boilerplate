<?php
declare(strict_types=1);

namespace App\Common\Domain\Aggregate;

use App\Common\Domain\Bus\DomainEvent\DomainEvent;
use App\Common\Domain\Bus\IntegrationEvent\IntegrationEvent;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class AggregateRoot
{
    /** @var DomainEvent[]  */
    private array $domainEvents = [];

    /** @var IntegrationEvent[] */
    private array $integrationEvents = [];

    final protected function write(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }

    final protected function publish(IntegrationEvent $integrationEvent): void
    {
        $this->integrationEvents[] = $integrationEvent;
    }

    /**
     * @return DomainEvent[]
     */
    public function pullDomainEvents(): array
    {
        $allDomainEvents = $this->domainEvents;

        $this->domainEvents = [];

        return $allDomainEvents;
    }

    /**
     * @return IntegrationEvent[]
     */
    public function pullIntegrationEvents(): array
    {
        $allIntegrationEvents = $this->integrationEvents;

        $this->integrationEvents = [];

        return $allIntegrationEvents;
    }
}
