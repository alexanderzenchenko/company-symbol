<?php

namespace App\Service\CompanySymbolService;

interface CompanySymbolServiceInterface
{
    /**
     * @param string $symbol
     * @return bool
     */
    public function validate(string $symbol): bool;
}
