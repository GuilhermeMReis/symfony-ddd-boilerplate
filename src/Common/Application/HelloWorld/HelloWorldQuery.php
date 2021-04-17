<?php
declare(strict_types=1);

namespace App\Common\Application\HelloWorld;

use App\Common\Infrastructure\CQRS\Query\Query;

class HelloWorldQuery implements Query
{
    public function __construct(public string $hello) {}
}
