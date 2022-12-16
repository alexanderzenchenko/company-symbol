<?php

namespace App\Service\CompanySymbolService\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class CompanySymbolClient implements CompanySymbolClientInterface
{
    protected const REQUEST_METHOD = 'GET';
    //TODO: move endpoint to env variable
    protected const ENDPOINT = 'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json';

    protected Client $client;
    protected LoggerInterface $logger;

    /**
     * @param Client $client
     * @param LoggerInterface $logger
     */
    public function __construct(Client $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public function getCompanies(): array
    {
        try {
            $response = $this->client->request(static::REQUEST_METHOD, static::ENDPOINT);

            if ($response->getStatusCode() !== Response::HTTP_OK) {
                $this->logger->info(
                    sprintf(
                        '[CompanyClient] Unexpected response. Response code: %s. Response: %s',
                        $response->getStatusCode(),
                        htmlspecialchars(addslashes($response->getBody()->getContents()))
                    )
                );
                return [];
            }

            $companies = $response->getBody()->getContents();

            return json_decode($companies, true);

        } catch (GuzzleException $exception) {
            $this->logger->warning(
                sprintf(
                    '[CompanyClient] Request was unsuccessful. Exception: %s. Message: %s',
                    $exception::class,
                    $exception->getMessage()
                )
            );

            return [];
        }
    }
}
