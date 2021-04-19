<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Doctrine\Error;

use RuntimeException;

class BaseDoctrineRepositoryException extends RuntimeException
{
    public function __construct($message = "", int $code = 500)
    {
        parent::__construct($message, $code, null);
    }
}
