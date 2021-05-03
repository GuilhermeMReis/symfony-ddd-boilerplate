<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Doctrine;

use App\Common\Domain\Aggregate\AggregateRoot;
use App\Common\Domain\Bus\DomainEvent\DomainEvent;
use App\Common\Domain\Bus\DomainEvent\DomainEventBus;
use App\Common\Domain\Bus\IntegrationEvent\IntegrationEvent;
use App\Common\Domain\Bus\IntegrationEvent\IntegrationEventBus;
use App\Common\Infrastructure\Doctrine\Error\BaseDoctrineRepositoryException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

abstract class BaseDoctrineRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private DomainEventBus $domainEventBus,
        private IntegrationEventBus $integrationEventBus
    ) {
        if (false === is_subclass_of($this->getAggregateRootClass(), AggregateRoot::class, true)) {
            throw new BaseDoctrineRepositoryException(sprintf('class specified does not extends AggregateRoot: %s in repository: %s', $this->getAggregateRootClass(), static::class));
        }

        parent::__construct($registry, $this->getAggregateRootClass());
    }

    abstract protected function getAggregateRootClass(): string;

    protected function persist(AggregateRoot $aggregateRoot): void
    {
        $this->getEntityManager()->persist($aggregateRoot);

        array_map(fn(DomainEvent $event) => $this->domainEventBus->dispatch($event), $aggregateRoot->pullDomainEvents());

        $this->getEntityManager()->flush();

        array_map(fn(IntegrationEvent $event) => $this->integrationEventBus->publish($event), $aggregateRoot->pullIntegrationEvents());
    }

    protected function remove(AggregateRoot $aggregateRoot): void
    {
        $this->getEntityManager()->remove($aggregateRoot);

        array_map(fn(DomainEvent $event) => $this->domainEventBus->dispatch($event), $aggregateRoot->pullDomainEvents());

        $this->getEntityManager()->flush();

        array_map(fn(IntegrationEvent $event) => $this->integrationEventBus->publish($event), $aggregateRoot->pullIntegrationEvents());
    }

    public function find($id, $lockMode = null, $lockVersion = null): ?AggregateRoot
    {
        return $this->getEntityManager()->find($this->getAggregateRootClass(), $id, $lockMode, $lockVersion);
    }
}
