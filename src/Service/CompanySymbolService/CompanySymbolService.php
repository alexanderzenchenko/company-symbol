<?php

namespace App\Service\CompanySymbolService;

use App\Service\CompanySymbolService\Client\CompanySymbolClientInterface;

class CompanySymbolService implements CompanySymbolServiceInterface
{
    protected CompanySymbolClientInterface $client;
    protected array $company = [];

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
        $this->getCompany($symbol);

        return !empty($this->company[$symbol]);
    }

    /**
     * @param string $symbol
     * @return array
     */
    public function getCompany(string $symbol): array
    {
        if (array_key_exists($symbol, $this->company)) {
            return $this->company[$symbol];
        }

        $this->company[$symbol] = $this->findCompanyBySymbol($symbol);

        return $this->company[$symbol];
    }

    /**
     * @param string $symbol
     * @return array
     */
    protected function findCompanyBySymbol(string $symbol): array
    {
        $companies = $this->client->getCompanies();
        foreach ($companies as $company) {
            if (strtoupper(trim($company['Symbol'])) === strtoupper(trim($symbol))) {
                return $company;
            }
        }

        return [];
    }
}
