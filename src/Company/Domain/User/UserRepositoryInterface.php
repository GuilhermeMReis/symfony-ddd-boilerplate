<?php

namespace App\Company\Domain\User;

use App\Common\Domain\ValueObject\Uuid;

interface UserRepositoryInterface
{
    public function findById(Uuid $userId): ?User;
    public function save(User $user): void;
}
