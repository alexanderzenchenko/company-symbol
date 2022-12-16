<?php

namespace App\Service\CompanyService\Reader;

use App\Entity\Company;

class CompanyMapper implements CompanyMapperInterface
{

    /**
     * @param array $company
     * @return Company
     */
    public function map(array $company): Company
    {
        return (new Company())
            ->setCompanyName($company['Company Name'])
            ->setFinancialStatus($company['Financial Status'])
            ->setMarketCategory($company['Market Category'])
            ->setRoundLotSize($company['Round Lot Size'])
            ->setSecurityName($company['Security Name'])
            ->setSymbol($company['Symbol'])
            ->setTestIssue($company['Test Issue']);
    }
}
