<?php
declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

use App\Common\Domain\Error\NoLabelMatchException;
use ReflectionClass;

abstract class Enum
{
    protected $value;
    protected static array $labels = [];

    public function __construct($value)
    {
        if (false === self::valueExist($value)) $this->throwException($value);

        $this->value = $value;
    }

    abstract protected function throwException($invalidValue): void;

    public static function constants(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }

    public static function valueExist($value): bool
    {
        return in_array($value, self::constants(), true);
    }

    public static function labelExist($value): bool
    {
        return array_key_exists($value, static::$labels);
    }

    public static function values(): array
    {
        return array_values(self::constants());
    }

    public static function labels(): array
    {
        return static::$labels;
    }

    public function value()
    {
        return $this->value;
    }

    public function label()
    {
        if (false === self::labelExist($this->value)) throw new NoLabelMatchException($this);

        return static::$labels[$this->value];
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }
}
