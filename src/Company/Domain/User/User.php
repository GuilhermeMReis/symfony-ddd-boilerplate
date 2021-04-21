<?php
declare(strict_types=1);

namespace App\Company\Domain\User;

use App\Common\Domain\Aggregate\AggregateRoot;
use App\Common\Domain\ValueObject\Title;
use App\Common\Domain\ValueObject\Uuid;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class User extends AggregateRoot
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

    /**
     * @ORM\Embedded(class="App\Common\Domain\ValueObject\Title", columnPrefix=false)
     */
    private ?Title $title;

    public function __construct(Uuid $id, string $name, ?Title $title = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTitle(): ?Title
    {
        return $this->title;
    }
}
