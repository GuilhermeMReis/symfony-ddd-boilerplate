<?php
declare(strict_types=1);

namespace App\Company\Application\HelloWorld;

use App\Common\Domain\Bus\Command\Command;

class HelloWorldCommand implements Command
{
    public function __construct(public string $hello) {}
}
