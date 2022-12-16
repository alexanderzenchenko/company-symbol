<?php

namespace App\Service\CompanyService\Validator;

use App\Service\CompanyService\Reader\CompanyReaderInterface;

class CompanyValidator implements CompanyValidatorInterface
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
