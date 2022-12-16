<?php

namespace App\Service\CompanySymbolService\Reader;

use App\Entity\Company;
use App\Service\CompanySymbolService\Client\CompanySymbolClientInterface;

class CompanyReader implements CompanyReaderInterface
{
    protected CompanySymbolClientInterface $client;
    protected CompanyMapperInterface $mapper;

    /**
     * @param CompanySymbolClientInterface $client
     * @param CompanyMapperInterface $mapper
     */
    public function __construct(
        CompanySymbolClientInterface $client,
        CompanyMapperInterface $mapper
    )
    {
        $this->client = $client;
        $this->mapper = $mapper;
    }

    /**
     * @param string $symbol
     * @return Company|null
     */
    public function getCompany(string $symbol): ?Company
    {
        $companies = $this->client->getCompanies();
        foreach ($companies as $company) {
            if (strtoupper(trim($company['Symbol'])) === strtoupper(trim($symbol))) {
                return $this->mapper->map($company);
            }
        }

        return null;
    }
}
