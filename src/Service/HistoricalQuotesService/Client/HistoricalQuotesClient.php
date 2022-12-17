<?php

namespace App\Service\HistoricalQuotesService\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class HistoricalQuotesClient implements HistoricalQuotesClientInterface
{
    protected const REQUEST_METHOD = 'GET';
    protected const PRICES_FIELD = 'prices';

    protected Client $client;
    protected LoggerInterface $logger;
    protected string $apiKey;
    protected string $apiHost;
    protected string $endpoint;

    /**
     * @param string $apiKey
     * @param string $apiHost
     * @param Client $client
     * @param LoggerInterface $logger
     * @param string $endpoint
     */
    public function __construct(string $apiKey, string $apiHost, Client $client, LoggerInterface $logger, string $endpoint)
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->apiKey = $apiKey;
        $this->apiHost = $apiHost;
        $this->endpoint = $endpoint;
    }

    /**
     * @param string $symbol
     * @return array
     */
    public function getHistoricalQuotes(string $symbol): array
    {
        try {
            $response = $this->client->request(static::REQUEST_METHOD, $this->endpoint, [
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

            if (!$content) {
                return [];
            }

            return array_key_exists(static::PRICES_FIELD, $content) ? $content[static::PRICES_FIELD] : [];
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
