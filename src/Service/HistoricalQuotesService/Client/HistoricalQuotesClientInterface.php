<?php

namespace App\Service\HistoricalQuotesService\Client;

interface HistoricalQuotesClientInterface
{
    /**
     * @param string $symbol
     * @return array
     */
    public function getHistoricalQuotes(string $symbol): array;
}
