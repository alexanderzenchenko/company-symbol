<?php

namespace App\Tests\Service\CompanyService\Reader;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Service\CompanyService\Reader\CompanyReader;
use App\Service\CompanyService\Reader\DbCompanyReader;
use PHPUnit\Framework\TestCase;

class DbCompanyReaderTest extends TestCase
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

        $repository = $this->createMock(CompanyRepository::class);
        $repository->expects($this->once())
            ->method('findOneBy')
            ->willReturn($company);

        $companyReader = $this->createMock(CompanyReader::class);
        $companyReader->expects($this->never())
            ->method('getCompany');

        $dbCompanyReader = new DbCompanyReader($companyReader, $repository);
        $dbCompanyReader->getCompany($company->getSymbol());
    }

    public function testGetCompanyFromApi()
    {
        $repository = $this->createMock(CompanyRepository::class);
        $repository->expects($this->once())
            ->method('findOneBy')
            ->willReturn(null);

        $companyReader = $this->createMock(CompanyReader::class);
        $companyReader->expects($this->once())
            ->method('getCompany');

        $dbCompanyReader = new DbCompanyReader($companyReader, $repository);
        $dbCompanyReader->getCompany('AEGN');
    }
}
