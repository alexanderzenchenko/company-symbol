<?php

namespace App\Service\CompanySymbolService\Reader;

use App\Entity\Company;

interface CompanyMapperInterface
{
    /**
     * @param array $company
     * @return Company
     */
    public function map(array $company): Company;
}
