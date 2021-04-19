<?php
declare(strict_types=1);

namespace App\Company\Infrastructure\Persistence;

use App\Common\Domain\ValueObject\Uuid;
use App\Common\Infrastructure\Doctrine\BaseDoctrineRepository;
use App\Company\Domain\User\User;
use App\Company\Domain\User\UserRepositoryInterface;

class UserRepository extends BaseDoctrineRepository implements UserRepositoryInterface
{
    protected function getAggregateRootClass(): string
    {
        return User::class;
    }

    public function findById(Uuid $userId): ?User
    {
        return $this->find($userId);
    }

    public function save(User $user): void
    {
        $this->persist($user);
    }
}
