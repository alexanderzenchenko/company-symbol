<?php

namespace App\Service\CompanyService\Client;

interface CompanyClientInterface
{
    /**
     * @return array
     */
    public function getCompanies(): array;
}
