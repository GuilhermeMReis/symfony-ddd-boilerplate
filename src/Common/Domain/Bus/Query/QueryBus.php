<?php

namespace App\Common\Domain\Bus\Query;

interface QueryBus
{
    /** @return mixed */
    public function handle(Query $query);
}
