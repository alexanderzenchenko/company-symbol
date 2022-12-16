<?php

namespace App\Service\CompanyService\Reader;

use App\Entity\Company;
use App\Service\CompanyService\Client\CompanyClientInterface;

class CompanyReader implements CompanyReaderInterface
{
    protected CompanyClientInterface $client;
    protected CompanyMapperInterface $mapper;

    /**
     * @param CompanyClientInterface $client
     * @param CompanyMapperInterface $mapper
     */
    public function __construct(
        CompanyClientInterface $client,
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
