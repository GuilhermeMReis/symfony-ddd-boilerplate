<?php
declare(strict_types=1);

namespace App\Common\Domain\Error;

use InvalidArgumentException;

class InvalidUuidStringException extends InvalidArgumentException
{
    public function __construct(string $value)
    {
        parent::__construct(sprintf("%s is not a valid uuid type.", $value));
    }
}
