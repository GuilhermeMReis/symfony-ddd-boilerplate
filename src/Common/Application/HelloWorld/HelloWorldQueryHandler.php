<?php
declare(strict_types=1);

namespace App\Common\Application\HelloWorld;

use App\Common\Infrastructure\CQRS\Query\QueryHandler;

class HelloWorldQueryHandler implements QueryHandler
{
    public function __invoke(HelloWorldQuery $query): HelloWorldQueryResult
    {
        return new HelloWorldQueryResult($query->hello);
    }
}
