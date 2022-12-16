<?php

namespace App\Tests\Service\CompanySymbolService;

use App\Entity\Company;
use App\Service\CompanySymbolService\CompanySymbolService;
use App\Service\CompanySymbolService\Reader\CompanyReader;
use PHPUnit\Framework\TestCase;

class CompanySymbolServiceTest extends TestCase
{

    /**
     * @dataProvider validateTrueDataProvider
     */
    public function testValidate($symbol, $result)
    {
        $company = (new Company())
            ->setCompanyName('Aegion Corp')
            ->setFinancialStatus('N')
            ->setMarketCategory('Q')
            ->setRoundLotSize(100.0)
            ->setSecurityName('Aegion Corp - Class A Common Stock')
            ->setSymbol('ABGB')
            ->setTestIssue('N');

        $reader = $this->createStub(CompanyReader::class);
        $reader->method('getCompany')
            ->willReturn($company);

        $validator = new CompanySymbolService($reader);

        $this->assertEquals($result, $validator->validate($symbol));
    }

    /**
     * @dataProvider validateFalseDataProvider
     */
    public function testValidateWhenCompanyNotFound($symbol, $result)
    {
        $reader = $this->createStub(CompanyReader::class);
        $reader->method('getCompany')
            ->willReturn(null);

        $validator = new CompanySymbolService($reader);

        $this->assertEquals($result, $validator->validate($symbol));
    }

    protected function validateTrueDataProvider(): array
    {
        return [
            ['ABGB', true],
            ['abgb', true],
        ];
    }

    protected function validateFalseDataProvider(): array
    {
        return [
            ['', false],
            ['123', false],
            ['sdj', false],
        ];
    }
}
