<?php

namespace App\Service\HistoricalQuotesService;

use App\Entity\HistoricalQuoteSearchData;

interface HistoricalQuotesServiceInterface
{
    /**
     * @param HistoricalQuoteSearchData $searchConditions
     * @return array
     */
    public function getPricesBySearchConditions(HistoricalQuoteSearchData $searchConditions): array;
}
