<?php
declare(strict_types=1);

namespace App\Common\Domain\Aggregate;

use App\Common\Domain\Bus\DomainEvent\DomainEvent;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class AggregateRoot
{
    /** @var DomainEvent[]  */
    private array $domainEvents = [];

    final protected function write(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
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
}