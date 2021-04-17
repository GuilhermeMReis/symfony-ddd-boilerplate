<?php

namespace App\Common\Infrastructure\CQRS\Query;

interface QueryBus
{
    /** @return mixed */
    public function handle(Query $query);
}
