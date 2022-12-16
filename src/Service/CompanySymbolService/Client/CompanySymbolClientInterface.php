<?php

namespace App\Service\CompanySymbolService\Client;

interface CompanySymbolClientInterface
{
    /**
     * @return array
     */
    public function getCompanies(): array;
}
