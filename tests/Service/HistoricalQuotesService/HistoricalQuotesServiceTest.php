<?php

namespace App\Tests\Service\HistoricalQuotesService;

use App\Entity\HistoricalQuoteSearchData;
use App\Service\HistoricalQuotesService\Client\HistoricalQuotesClient;
use App\Service\HistoricalQuotesService\HistoricalQuotesService;
use PHPUnit\Framework\TestCase;

class HistoricalQuotesServiceTest extends TestCase
{
    public function testClientWasInvoked()
    {
        $searchData = new HistoricalQuoteSearchData();
        $searchData->setCompanySymbol('AAIT');
        $searchData->setStartDate(new \DateTime('2022-12-09'));
        $searchData->setEndDate(new \DateTime('2022-12-14'));
        $searchData->setEmail('test@email.com');

        $historicalQuotesClient = $this->createMock(HistoricalQuotesClient::class);
        $historicalQuotesClient->expects($this->once())
            ->method('getHistoricalQuotes')
            ->with($searchData->getCompanySymbol());

        $service = new HistoricalQuotesService($historicalQuotesClient);
        $service->getPricesBySearchConditions($searchData);
    }

    public function testGetPricesBySearchConditions()
    {
        $searchData = new HistoricalQuoteSearchData();
        $searchData->setCompanySymbol('AAIT');
        $searchData->setStartDate(new \DateTime('2022-12-09'));
        $searchData->setEndDate(new \DateTime('2022-12-14'));
        $searchData->setEmail('test@email.com');

        $historicalQuotesClient = $this->createStub(HistoricalQuotesClient::class);
        $historicalQuotesClient->method('getHistoricalQuotes')
            ->willReturn($this->historicalData());

        $service = new HistoricalQuotesService($historicalQuotesClient);

        $this->assertEquals($this->historicalData(), $service->getPricesBySearchConditions($searchData));
    }

    protected function historicalData(): array
    {
        return json_decode('[
        {
            "date": 1671051604,
            "open": 2.509999990463257,
            "high": 2.509999990463257,
            "low": 2.4100000858306885,
            "close": 2.4100000858306885,
            "volume": 8,
            "adjclose": 2.4100000858306885
        },
        {
            "date": 1670941800,
            "open": 2.5,
            "high": 2.6700000762939453,
            "low": 2.5,
            "close": 2.6700000762939453,
            "volume": 8400,
            "adjclose": 2.6700000762939453
        },
        {
            "date": 1670855400,
            "open": 2.5,
            "high": 2.6600000858306885,
            "low": 2.5,
            "close": 2.6600000858306885,
            "volume": 7200,
            "adjclose": 2.6600000858306885
        },
        {
            "date": 1670596200,
            "open": 2.569999933242798,
            "high": 2.5799999237060547,
            "low": 2.5299999713897705,
            "close": 2.569999933242798,
            "volume": 3600,
            "adjclose": 2.569999933242798
        }]',
        true
        );
    }
}
