<?php

namespace App\Service\CompanyService\Reader;

use App\Entity\Company;
use Doctrine\Persistence\ManagerRegistry;

class CompanyReaderWrapper implements CompanyReaderInterface
{
    protected CompanyReaderInterface $reader;
    protected ManagerRegistry $registry;

    /**
     * @param CompanyReaderInterface $reader
     * @param ManagerRegistry $registry
     */
    public function __construct(
        CompanyReaderInterface $reader,
        ManagerRegistry $registry
    )
    {
        $this->reader = $reader;
        $this->registry = $registry;
    }

    /**
     * @param string $symbol
     * @return Company|null
     */
    public function getCompany(string $symbol): ?Company
    {
        $company = $this->reader->getCompany($symbol);

        if ($company === null) {
            return null;
        }

        $this->saveCompany($company);

        return $company;
    }

    /**
     * @param Company $company
     * @return void
     */
    protected function saveCompany(Company $company): void
    {
        $entityManager = $this->registry->getManager();
        $entityManager->persist($company);
        $entityManager->flush();
    }

}
