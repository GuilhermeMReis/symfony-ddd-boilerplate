<?php
declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

use Doctrine\ORM\Mapping\Embeddable;
use Doctrine\ORM\Mapping as ORM;

/** @Embeddable */
class Title extends Enum
{
    public const MR = 'mr';
    public const MRS = 'mrs';
    public const MS = 'ms';
    public const MISS = 'miss';

    /** @ORM\Column(type="string", name="user_title", nullable=true) */
    protected $value;

    protected static array $labels = [
        self::MR => 'Mr',
        self::MRS => 'Mrs',
        self::MS => 'Ms',
        self::MISS => 'Miss'
    ];

    protected function throwException($invalidValue): void
    {
        throw new \InvalidArgumentException(sprintf('%s is not a valid user title.', $invalidValue));
    }
}
