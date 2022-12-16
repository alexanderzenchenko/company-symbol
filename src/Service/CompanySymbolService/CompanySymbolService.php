<?php

namespace App\Service\CompanySymbolService;

use App\Service\CompanySymbolService\Reader\CompanyReaderInterface;

class CompanySymbolService implements CompanySymbolServiceInterface
{
    protected CompanyReaderInterface $reader;

    /**
     * @param CompanyReaderInterface $reader
     */
    public function __construct(CompanyReaderInterface $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param string $symbol
     * @return bool
     */
    public function validate(string $symbol): bool
    {
        $company = $this->reader->getCompany($symbol);

        return $company !== null;
    }
}
