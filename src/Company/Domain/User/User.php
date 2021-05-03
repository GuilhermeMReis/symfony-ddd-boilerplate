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

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $fakeWelcomeEmailSent;

    /**
     * @ORM\Column(type="uuid_type", nullable=true)
     */
    private ?Uuid $fakeEmailValidationId;

    public function __construct(Uuid $id, string $name, ?Title $title = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
        $this->fakeWelcomeEmailSent = false;
        $this->fakeEmailValidationId = null;

        $this->write(new UserCreated($this));
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

    public function isFakeWelcomeEmailSent(): bool
    {
        return $this->fakeWelcomeEmailSent;
    }

    public function getFakeEmailValidationId(): ?Uuid
    {
        return $this->fakeEmailValidationId;
    }

    public function markWelcomeEmailAsSent(Uuid $emailValidationId): void
    {
        $this->fakeWelcomeEmailSent = true;
        $this->fakeEmailValidationId = $emailValidationId;

        $this->publish(new UserWelcomeEmailSent($this));
    }
}
