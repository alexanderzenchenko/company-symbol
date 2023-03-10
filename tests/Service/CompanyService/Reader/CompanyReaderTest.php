<?php

namespace App\Tests\Service\CompanyService\Reader;

use App\Service\CompanyService\Client\CompanyClient;
use App\Service\CompanyService\Reader\CompanyMapper;
use App\Service\CompanyService\Reader\CompanyReader;
use PHPUnit\Framework\TestCase;

class CompanyReaderTest extends TestCase
{

    public function testGetCompany()
    {
        $client = $this->createStub(CompanyClient::class);
        $client->method('getCompanies')
            ->willReturn($this->companiesDataProvider());

        $companyReader = new CompanyReader($client, new CompanyMapper());

        $company = $companyReader->getCompany('');
        $this->assertNull( $company);

        $company = $companyReader->getCompany('123');
        $this->assertNull($company);

        $company = $companyReader->getCompany('AAIT');
        $this->assertIsObject($company);
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

}
