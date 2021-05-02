<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

abstract class FormRequest
{
    public ?Request $request;

    public function __construct(RequestStack $requestStack, private ValidatorInterface $validator)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    abstract protected function rules(): Assert\Collection;

    public function validate(): FormRequestValidationResult
    {
        $violations = $this->validator->validate($this->request->request->all(), $this->rules());

        return new FormRequestValidationResult(0 === $violations->count(), $violations->count() ? $violations : null);
    }
}
