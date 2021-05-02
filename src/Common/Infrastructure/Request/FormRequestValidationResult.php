<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Request;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class FormRequestValidationResult
{
    public bool $isValid;
    public array $violations;

    public function __construct(bool $isValid, ?ConstraintViolationListInterface $violationList)
    {
        $this->isValid = $isValid;
        $this->violations = $violationList ? $this->getViolations($violationList) : [];
    }

    private function getViolations(ConstraintViolationListInterface $violationList): array
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $errorMessages = [];
        foreach ($violationList as $violation) {
            $accessor->setValue($errorMessages,
                $violation->getPropertyPath(),
                $violation->getMessage());
        }

        return $errorMessages;
    }
}
