<?php
declare(strict_types=1);

namespace App\Common\Application\HelloWorld;

use App\Common\Infrastructure\CQRS\Command\Command;

class HelloWorldCommand implements Command
{
    public function __construct(public string $hello) {}
}
