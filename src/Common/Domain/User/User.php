<?php
declare(strict_types=1);

namespace App\Common\Domain\User;

use App\Common\Infrastructure\Doctrine\Types\UuidType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid_type")
     */
    private UuidType $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    public function __construct(UuidType $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): UuidType
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
