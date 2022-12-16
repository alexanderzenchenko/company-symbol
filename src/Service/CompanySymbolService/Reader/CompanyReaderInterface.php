<?php

namespace App\Service\CompanySymbolService\Reader;

use App\Entity\Company;

interface CompanyReaderInterface
{
    /**
     * @param string $symbol
     * @return Company|null
     */
    public function getCompany(string $symbol): ?Company;
}
