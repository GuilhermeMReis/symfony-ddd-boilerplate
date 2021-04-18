<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\Command;

use App\Common\Domain\Bus\Command\Command;
use App\Common\Domain\Bus\Command\CommandBus;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBus implements CommandBus
{
    public function __construct(private MessageBusInterface $commandBus) {}

    public function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
