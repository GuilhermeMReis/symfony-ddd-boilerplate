<?php
declare(strict_types=1);

namespace App\Company\Application\HelloWorld;

class HelloWorldQueryResult
{
    public string $hello;

    public function __construct(string $hello)
    {
        $this->hello = $hello;
    }
}
