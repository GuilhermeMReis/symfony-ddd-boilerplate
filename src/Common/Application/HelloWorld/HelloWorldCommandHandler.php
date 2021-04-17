<?php
declare(strict_types=1);

namespace App\Common\Application\HelloWorld;

use App\Common\Domain\Bus\Command\CommandHandler;

class HelloWorldCommandHandler implements CommandHandler
{
    public function __invoke(HelloWorldCommand $command): void
    {
        //todo: persist something from $command->hello
    }
}
