<?php
declare(strict_types=1);

namespace App\Company\Domain\User;

use App\Common\Domain\Bus\DomainEvent\DomainEvent;

class UserCreated extends DomainEvent
{
    public function __construct(public User $user) {}
}
