<?php

namespace jtx\foreup\Services;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractFoldApi
{
    /**
     * @var Client
     */
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param ResponseInterface $res
     * @return bool
     */
    protected function responseOK(ResponseInterface $res): bool
    {
        $statusCode = $res->getStatusCode();

        return $statusCode == 200;
    }
}