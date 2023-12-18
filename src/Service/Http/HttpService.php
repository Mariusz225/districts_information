<?php

namespace App\Service\Http;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpService
{
    public function __construct(
        private readonly HttpClientInterface $client,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function getResponse($url, $method = 'GET'): \Symfony\Contracts\HttpClient\ResponseInterface
    {
        return $this->client->request($method, $url);

    }
}
