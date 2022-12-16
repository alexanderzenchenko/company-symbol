<?php

namespace App\Service\CompanyService\Reader;

use App\Entity\Company;
use App\Repository\CompanyRepository;

class DbCompanyReader implements CompanyReaderInterface
{
    protected CompanyReaderInterface $reader;
    protected CompanyRepository $repository;

    /**
     * @param CompanyReaderInterface $reader
     * @param CompanyRepository $repository
     */
    public function __construct(
        CompanyReaderInterface $reader,
        CompanyRepository $repository
    )
    {
        $this->reader = $reader;
        $this->repository = $repository;
    }

    /**
     * @param string $symbol
     * @return Company|null
     */
    public function getCompany(string $symbol): ?Company
    {
        $company = $this->repository->findOneBy(['symbol' => strtoupper($symbol)]);

        return $company !== null ? $company : $this->reader->getCompany($symbol);
    }
}
