<?php

namespace App\Common\Infrastructure\CQRS\Command;

interface CommandBus
{
    public function dispatch(Command $command): void;
}
