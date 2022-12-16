<?php

namespace App\Service\CompanyService\Reader;

use App\Entity\Company;

interface CompanyMapperInterface
{
    /**
     * @param array $company
     * @return Company
     */
    public function map(array $company): Company;
}
