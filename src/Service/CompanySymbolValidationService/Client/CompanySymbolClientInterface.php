<?php

namespace App\Service\CompanySymbolValidationService\Client;

interface CompanySymbolClientInterface
{
    /**
     * @return array
     */
    public function getCompanies(): array;
}
