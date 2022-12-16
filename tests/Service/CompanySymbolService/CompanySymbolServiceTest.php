<?php

namespace App\Tests\Service\CompanySymbolService;

use App\Service\CompanySymbolService\Client\CompanySymbolClient;
use App\Service\CompanySymbolService\CompanySymbolService;
use PHPUnit\Framework\TestCase;

class CompanySymbolServiceTest extends TestCase
{

    public function testCompanySymbolClientWasInvoked()
    {
        $client = $this->createMock(CompanySymbolClient::class);
        $client->expects($this->once())
            ->method('getCompanies');

        $companySymbolService = new CompanySymbolService($client);
        $company = $companySymbolService->getCompany('');
    }

    public function testGetCompany()
    {
        $client = $this->createStub(CompanySymbolClient::class);
        $client->method('getCompanies')
            ->willReturn($this->companiesDataProvider());

        $companySymbolService = new CompanySymbolService($client);
        $company = $companySymbolService->getCompany('');

        $this->assertEquals([], $company);
    }

    /**
     * @dataProvider validateDataProvider
     */
    public function testValidate($symbol, $result)
    {
        $client = $this->createStub(CompanySymbolClient::class);
        $client->method('getCompanies')
            ->willReturn($this->companiesDataProvider());

        $companySymbolService = new CompanySymbolService($client);

        $this->assertEquals($result, $companySymbolService->validate($symbol));

    }

    protected function companiesDataProvider(): array
    {
        return json_decode(
            '[
                {
                "Company Name": "iShares MSCI All Country Asia Information Technology Index Fund",
                "Financial Status": "N",
                "Market Category": "G",
                "Round Lot Size": 100.0,
                "Security Name": "iShares MSCI All Country Asia Information Technology Index Fund",
                "Symbol": "AAIT",
                "Test Issue": "N"
                },
                {
                "Company Name": "Anchor BanCorp Wisconsin Inc.",
                "Financial Status": "N",
                "Market Category": "Q",
                "Round Lot Size": 100.0,
                "Security Name": "Anchor BanCorp Wisconsin Inc. - Common Stock",
                "Symbol": "ABCW",
                "Test Issue": "N"
                },
                {
                "Company Name": "Alcentra Capital Corp.",
                "Financial Status": "N",
                "Market Category": "Q",
                "Round Lot Size": 100.0,
                "Security Name": "Alcentra Capital Corp. - Common Stock",
                "Symbol": "ABDC",
                "Test Issue": "N"
                },
                {
                "Company Name": "Abengoa, S.A.",
                "Financial Status": "N",
                "Market Category": "Q",
                "Round Lot Size": 100.0,
                "Security Name": "Abengoa, S.A. - American Depositary Shares",
                "Symbol": "ABGB",
                "Test Issue": "N"
                }]',
            true
        );
    }

    protected function validateDataProvider(): array
    {
        return [
            ['ABGB', true],
            ['abgb', true],
            ['ABDc', true],
            ['AAIT', true],
            ['', false],
            ['123', false],
            ['sdj', false],
        ];
    }
}
