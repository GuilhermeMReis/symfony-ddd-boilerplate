<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Doctrine\Type;

use Ramsey\Uuid\Doctrine\UuidType as RamseyUuidType;

class UuidType extends RamseyUuidType
{
    public const NAME = 'uuid_type';
}