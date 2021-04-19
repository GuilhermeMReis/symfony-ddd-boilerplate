<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Doctrine;

use App\Common\Domain\Aggregate\AggregateRoot;
use App\Common\Domain\Bus\DomainEvent\DomainEventBus;
use App\Common\Infrastructure\Doctrine\Error\BaseDoctrineRepositoryException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

abstract class BaseDoctrineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private DomainEventBus $domainEventBus)
    {
        if (false === is_subclass_of($this->getAggregateRootClass(), AggregateRoot::class, true)) {
            throw new BaseDoctrineRepositoryException(sprintf('class specified does not extends AggregateRoot: %s in repository: %s', $this->getAggregateRootClass(), static::class));
        }

        parent::__construct($registry, $this->getAggregateRootClass());
    }

    abstract protected function getAggregateRootClass(): string;

    protected function persist(AggregateRoot $entity): void
    {
        $this->getEntityManager()->persist($entity);

        foreach($entity->pullDomainEvents() as $domainEvent){
            $this->domainEventBus->dispatch($domainEvent);
        }

        $this->getEntityManager()->flush();
    }

    protected function remove(AggregateRoot $entity): void
    {
        $this->getEntityManager()->remove($entity);

        foreach ($entity->pullDomainEvents() as $domainEvent){
            $this->domainEventBus->dispatch($domainEvent);
        }

        $this->getEntityManager()->flush();
    }

    public function find($id, $lockMode = null, $lockVersion = null): ?AggregateRoot
    {
        return $this->getEntityManager()->find($this->getAggregateRootClass(), $id, $lockMode, $lockVersion);
    }
}
