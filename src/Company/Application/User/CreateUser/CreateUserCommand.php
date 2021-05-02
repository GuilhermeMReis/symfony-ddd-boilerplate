<?php
declare(strict_types=1);

namespace App\Company\Application\User\CreateUser;

use App\Common\Domain\Bus\Command\Command;
use App\Common\Domain\ValueObject\Title;
use App\Common\Domain\ValueObject\Uuid;

class CreateUserCommand implements Command
{
    public function __construct(
        public Uuid $newUserId,
        public string $name,
        public Title $title
    ) {}
}
