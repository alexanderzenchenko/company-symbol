<?php

namespace App\Validator;

use App\Service\CompanyService\Validator\CompanyValidatorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ConstrainsCompanySymbolValidator extends ConstraintValidator
{
    protected CompanyValidatorInterface $validator;

    /**
     * @param CompanyValidatorInterface $validator
     */
    public function __construct(CompanyValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param mixed $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof ConstrainsCompanySymbol) {
            throw new UnexpectedTypeException($constraint, ConstrainsCompanySymbol::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if ($this->validator->validate($value)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $value)
            ->addViolation();
    }
}
