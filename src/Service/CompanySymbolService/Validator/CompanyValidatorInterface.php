<?php

namespace App\Service\CompanySymbolService\Validator;

interface CompanyValidatorInterface
{
    /**
     * @param string $symbol
     * @return bool
     */
    public function validate(string $symbol): bool;
}
