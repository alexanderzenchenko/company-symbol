<?php

namespace App\Service\CompanyService\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class CompanyClient implements CompanyClientInterface
{
    protected const REQUEST_METHOD = 'GET';

    protected Client $client;
    protected LoggerInterface $logger;
    protected string $endpoint;

    /**
     * @param Client $client
     * @param LoggerInterface $logger
     * @param string $endpoint
     */
    public function __construct(Client $client, LoggerInterface $logger, string $endpoint)
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->endpoint = $endpoint;
    }

    /**
     * @return array
     */
    public function getCompanies(): array
    {
        try {
            $response = $this->client->request(static::REQUEST_METHOD, $this->endpoint);

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
