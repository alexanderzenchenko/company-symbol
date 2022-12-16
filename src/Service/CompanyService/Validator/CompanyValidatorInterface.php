<?php

namespace App\Service\CompanyService\Validator;

interface CompanyValidatorInterface
{
    /**
     * @param string $symbol
     * @return bool
     */
    public function validate(string $symbol): bool;
}
