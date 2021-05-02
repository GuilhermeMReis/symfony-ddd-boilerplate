<?php
declare(strict_types=1);

namespace App\Company\Application\User\CreateUser;

use App\Common\Domain\Bus\Command\CommandHandler;
use App\Company\Domain\User\User;
use App\Company\Domain\User\UserRepositoryInterface;

class CreateUserCommandHandler implements CommandHandler
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function __invoke(CreateUserCommand $command): void
    {
        $user = new User($command->newUserId, $command->name, $command->title);

        $this->userRepository->save($user);
    }
}
