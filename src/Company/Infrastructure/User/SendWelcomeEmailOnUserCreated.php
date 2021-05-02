<?php
declare(strict_types=1);

namespace App\Company\Infrastructure\User;

use App\Common\Domain\Bus\DomainEvent\DomainEventListener;
use App\Common\Domain\ValueObject\Uuid;
use App\Company\Domain\User\UserCreated;

class SendWelcomeEmailOnUserCreated implements DomainEventListener
{
    public function __invoke(UserCreated $userCreated): void
    {
        $emailValidationId = new Uuid();

        # Logic to fire off email to the user here...

        $userCreated->user->markWelcomeEmailAsSent($emailValidationId);
    }
}
