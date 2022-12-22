<?php

namespace Webmasterskaya\Soap\Base\Driver\ExtSoap;

use Soap\Engine\Encoder;
use Soap\Engine\HttpBinding\SoapRequest;

class ExtSoapEncoder implements Encoder
{
    /**
     * @var ClientProviderInterface
     */
    private $client;

    public function __construct(ClientProviderInterface $client)
    {
        $this->client = $client;
    }

    public function encode(string $method, array $arguments): SoapRequest
    {
        try {
            $this->client->__soapCall($method, $arguments);
            $encoded = $this->client->collectRequest();
        } finally {
            $this->client->cleanUpTemporaryState();
        }

        return $encoded;
    }
}