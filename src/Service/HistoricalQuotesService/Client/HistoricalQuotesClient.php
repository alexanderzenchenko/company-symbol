<?php

namespace App\Service\HistoricalQuotesService\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

class HistoricalQuotesClient implements HistoricalQuotesClientInterface
{
    protected const REQUEST_METHOD = 'GET';
    //TODO: move endpoint to env variable
    protected const ENDPOINT = 'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data';

    protected Client $client;
    protected string $apiKey;
    protected string $apiHost;

    /**
     * @param Client $client
     */
    public function __construct(Client $client, string $apiKey, string $apiHost)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->apiHost = $apiHost;
    }

    /**
     * @param string $symbol
     * @return array
     */
    public function getHistoricalQuotes(string $symbol): array
    {
        try {
            $response = $this->client->request(static::REQUEST_METHOD, static::ENDPOINT, [
                'headers' => [
                    'X-RapidAPI-Key' => $this->apiKey,
                    'X-RapidAPI-Host' => $this->apiHost,
                ],
                'query' => [
                    'symbol' => $symbol,
                ],
            ]);

            if ($response->getStatusCode() !== Response::HTTP_OK) {
                //TODO: log response
                return [];
            }

            $content = json_decode($response->getBody()->getContents(), true);

            return $content['prices'];
        } catch (GuzzleException $exception) {
            //TODO: log exception
            return [];
        }
    }
}
