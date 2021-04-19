<?php
declare(strict_types=1);

namespace App\Company\Application\HelloWorld;

use App\Common\Domain\Bus\Query\QueryHandler;

class HelloWorldQueryHandler implements QueryHandler
{
    public function __invoke(HelloWorldQuery $query): HelloWorldQueryResult
    {
        return new HelloWorldQueryResult($query->hello);
    }
}
