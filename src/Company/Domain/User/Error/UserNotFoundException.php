<?php
declare(strict_types=1);

namespace App\Company\Domain\User\Error;

use App\Common\Domain\ValueObject\Uuid;

class UserNotFoundException extends \DomainException
{
    public function __construct(Uuid $userId)
    {
        parent::__construct(sprintf('User not found for the given id: %s', $userId->getValue()), 404);
    }
}
