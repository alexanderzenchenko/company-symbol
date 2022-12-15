<?php

namespace App\Service\CompanySymbolValidationService;

use App\Service\CompanySymbolValidationService\Client\CompanySymbolClientInterface;

class CompanySymbolValidationService implements CompanySymbolValidationServiceInterface
{
    protected CompanySymbolClientInterface $client;

    /**
     * @param CompanySymbolClientInterface $client
     */
    public function __construct(CompanySymbolClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $symbol
     * @return bool
     */
    public function validate(string $symbol): bool
    {
        $companies = $this->client->getCompanies();
        foreach ($companies as $company) {
            if (strtoupper(trim($company['Symbol'])) === strtoupper(trim($symbol))) {
                return true;
            }
        }

        return false;
    }
}
