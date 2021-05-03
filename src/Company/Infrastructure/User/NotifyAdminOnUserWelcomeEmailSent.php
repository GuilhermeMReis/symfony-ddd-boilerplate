<?php
declare(strict_types=1);

namespace App\Company\Infrastructure\User;

use App\Common\Domain\Bus\IntegrationEvent\IntegrationEventListener;
use App\Common\Domain\ValueObject\Uuid;
use App\Company\Domain\User\Error\UserNotFoundException;
use App\Company\Domain\User\UserRepositoryInterface;
use App\Company\Domain\User\UserWelcomeEmailSent;

class NotifyAdminOnUserWelcomeEmailSent implements IntegrationEventListener
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function __invoke(UserWelcomeEmailSent $event): void
    {
        $user = $this->userRepository->findById($userId = new Uuid($event->userId));

        if (true === is_null($user)) throw new UserNotFoundException($userId);

        # Process any logic here to notify the Admin about a new welcome email sent to a new user.
    }
}
