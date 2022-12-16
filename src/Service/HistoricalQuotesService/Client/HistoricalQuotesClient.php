<?php

namespace App\Service\HistoricalQuotesService\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class HistoricalQuotesClient implements HistoricalQuotesClientInterface
{
    protected const REQUEST_METHOD = 'GET';
    //TODO: move endpoint to env variable
    protected const ENDPOINT = 'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data';

    protected Client $client;
    protected LoggerInterface $logger;
    protected string $apiKey;
    protected string $apiHost;

    /**
     * @param string $apiKey
     * @param string $apiHost
     * @param Client $client
     * @param LoggerInterface $logger
     */
    public function __construct(string $apiKey, string $apiHost, Client $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
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
                $this->logger->info(
                    sprintf(
                        '[HistoricalQuotes] Unexpected response. Response code: %s. Response: %s',
                        $response->getStatusCode(),
                        htmlspecialchars(addslashes($response->getBody()->getContents()))
                    )
                );
                return [];
            }

            $content = json_decode($response->getBody()->getContents(), true);

            return $content['prices'];
        } catch (GuzzleException $exception) {
            $this->logger->warning(
                sprintf(
                    '[HistoricalQuotes] Request was unsuccessful. Exception: %s. Message: %s',
                    $exception::class,
                    $exception->getMessage()
                )
            );

            return [];
        }
    }
}
