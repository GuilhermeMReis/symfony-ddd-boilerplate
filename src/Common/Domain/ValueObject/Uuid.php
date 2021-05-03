<?php
declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

use App\Common\Domain\Error\InvalidUuidStringException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    protected string $value;

    public function __construct(string $value = '')
    {
        if (true === empty($value)) {
            $value = RamseyUuid::uuid1()->toString();
        }

        if (false === RamseyUuid::isValid($value)) {
            throw new InvalidUuidStringException($value);
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }

    public static function isValid(string $value): bool
    {
        return RamseyUuid::isValid($value);
    }
}
