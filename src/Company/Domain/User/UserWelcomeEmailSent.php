<?php
declare(strict_types=1);

namespace App\Company\Domain\User;

use App\Common\Domain\Bus\IntegrationEvent\IntegrationEvent;

/**
 * Remembers, it's not ideal to hold classes on public properties on a integration event as Symfony will try to
 * serialise this class and unserialise it for the listener.
 *
 * You will have access to any public property available on your listener.
 */
class UserWelcomeEmailSent extends IntegrationEvent
{
    public string $userId;

    public function __construct(User $user)
    {
        $this->userId = $user->getId()->getValue();
    }
}
