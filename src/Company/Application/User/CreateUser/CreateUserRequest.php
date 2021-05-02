<?php
declare(strict_types=1);

namespace App\Company\Application\User\CreateUser;

use App\Common\Domain\ValueObject\Title;
use App\Common\Infrastructure\Request\FormRequest;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserRequest extends FormRequest
{
    public const NAME = 'name';
    public const TITLE = 'title';

    protected function rules(): Assert\Collection
    {
        return new Assert\Collection([
            self::NAME => [new Assert\Length(['min' => 2]), new Assert\NotBlank],
            self::TITLE => [new Assert\Choice(Title::values()), new Assert\NotBlank],
        ]);
    }
}
