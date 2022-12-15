<?php

namespace App\Service\CompanySymbolValidationService\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

class CompanySymbolClient implements CompanySymbolClientInterface
{
    protected const REQUEST_METHOD = 'GET';
    //TODO: move endpoint to env variable
    protected const ENDPOINT = 'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json';

    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function getCompanies(): array
    {
        try {
            $response = $this->client->request(static::REQUEST_METHOD, static::ENDPOINT);

            if ($response->getStatusCode() !== Response::HTTP_OK) {
                //TODO: Log response
                return [];
            }

            $companies = $response->getBody()->getContents();

            return json_decode($companies, true);

        } catch (GuzzleException $guzzleException) {
            //TODO: log exception
            return [];
        }
    }
}
