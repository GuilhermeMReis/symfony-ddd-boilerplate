<?php
declare(strict_types=1);

namespace App\Common\Domain\User;

use App\Common\Domain\ValueObject\Uuid;
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
    private Uuid $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    public function __construct(Uuid $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
