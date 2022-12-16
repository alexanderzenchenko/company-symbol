<?php

namespace App\Tests\Service\CompanyService\Reader;

use App\Entity\Company;
use App\Service\CompanyService\Reader\CompanyReader;
use App\Service\CompanyService\Reader\CompanyReaderWrapper;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class CompanyReaderWrapperTest extends TestCase
{

    public function testGetCompany()
    {
        $company = (new Company())
            ->setCompanyName('Aegion Corp')
            ->setFinancialStatus('N')
            ->setMarketCategory('Q')
            ->setRoundLotSize(100.0)
            ->setSecurityName('Aegion Corp - Class A Common Stock')
            ->setSymbol('AEGN')
            ->setTestIssue('N');

        $companyReader = $this->createMock(CompanyReader::class);
        $companyReader->expects($this->once())
            ->method('getCompany')
            ->willReturn($company);

        $entityManager = $this->createMock(ObjectManager::class);
        $entityManager->expects($this->once())
            ->method('persist');
        $entityManager->expects($this->once())
            ->method('flush');

        $managerRegistry = $this->createMock(ManagerRegistry::class);
        $managerRegistry->expects($this->once())
            ->method('getManager')
            ->willReturn($entityManager);

        $companyReaderWrapper = new CompanyReaderWrapper($companyReader, $managerRegistry);
        $companyReaderWrapper->getCompany($company->getSymbol());
    }

    public function testGetCompanyIfReaderReturnNull()
    {
        $companyReader = $this->createMock(CompanyReader::class);
        $companyReader->expects($this->once())
            ->method('getCompany')
            ->willReturn(null);

        $entityManager = $this->createMock(ObjectManager::class);
        $entityManager->expects($this->never())
            ->method('persist');
        $entityManager->expects($this->never())
            ->method('flush');

        $managerRegistry = $this->createMock(ManagerRegistry::class);
        $managerRegistry->expects($this->never())
            ->method('getManager')
            ->willReturn($entityManager);

        $companyReaderWrapper = new CompanyReaderWrapper($companyReader, $managerRegistry);
        $companyReaderWrapper->getCompany('');
    }
}
