<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Doctrine\Type;

use App\Common\Domain\ValueObject\Uuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Ramsey\Uuid\Doctrine\UuidType as RamseyUuidType;

class UuidType extends RamseyUuidType
{
    public const NAME = 'uuid_type';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (is_null($value) ? null : new Uuid($value));
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) return null;

        if ($value instanceof Uuid) return $value->getValue();

        if (is_string($value) && Uuid::isValid($value)) return $value;

        throw ConversionException::conversionFailed($value, self::NAME);
    }
}
