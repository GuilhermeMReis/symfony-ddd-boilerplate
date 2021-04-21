<?php
declare(strict_types=1);

namespace App\Common\Domain\Error;

use App\Common\Domain\ValueObject\Enum;
use DomainException;

class NoLabelMatchException extends DomainException
{
    public function __construct(Enum $enum)
    {
        parent::__construct(sprintf('%s: No label matched for the value: %s', get_class($enum), $enum->value()), 500);
    }
}
