<?php

namespace App\Service\CompanySymbolValidationService;

interface CompanySymbolValidationServiceInterface
{
    /**
     * @param string $symbol
     * @return bool
     */
    public function validate(string $symbol): bool;
}
