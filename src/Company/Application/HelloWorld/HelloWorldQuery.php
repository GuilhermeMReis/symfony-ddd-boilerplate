<?php
declare(strict_types=1);

namespace App\Company\Application\HelloWorld;

use App\Common\Domain\Bus\Query\Query;

class HelloWorldQuery implements Query
{
    public function __construct(public string $hello) {}
}
