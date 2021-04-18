<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Doctrine\Types;

use Ramsey\Uuid\Doctrine\UuidType as RamseyUuid;

class UuidType extends RamseyUuid
{
    public const NAME = 'uuid_type';
}
