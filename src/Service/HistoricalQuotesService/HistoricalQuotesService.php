<?php

namespace App\Service\HistoricalQuotesService;

use App\Entity\HistoricalQuoteSearchData;
use App\Service\HistoricalQuotesService\Client\HistoricalQuotesClientInterface;

class HistoricalQuotesService implements HistoricalQuotesServiceInterface
{
    protected HistoricalQuotesClientInterface $client;

    /**
     * @param HistoricalQuotesClientInterface $client
     */
    public function __construct(HistoricalQuotesClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param HistoricalQuoteSearchData $searchConditions
     * @return array
     */
    public function getPricesBySearchConditions(HistoricalQuoteSearchData $searchConditions): array
    {
        $prices = $this->client->getHistoricalQuotes($searchConditions->getCompanySymbol());

        return array_filter($prices, function($price) use ($searchConditions) {
            return $price['date'] >= $searchConditions->getStartDate()->getTimestamp()
                && $price['date'] <= $searchConditions->getEndDate()->setTime(23, 59, 59)->getTimestamp();
        });
    }
}
