<?php

namespace App\Service\CompanySymbolService;

interface CompanySymbolServiceInterface
{
    /**
     * @param string $symbol
     * @return bool
     */
    public function validate(string $symbol): bool;

    /**
     * @param string $symbol
     * @return array
     */
    public function getCompany(string $symbol): array;
}
