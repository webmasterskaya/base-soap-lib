<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Driver\ExtSoap;

use Soap\Engine\Decoder;
use Soap\Engine\HttpBinding\SoapResponse;
use Webmasterskaya\Soap\Base\Driver\ExtSoap\Generator\DummyMethodArgumentsGenerator;

final class ExtSoapDecoder implements Decoder
{
    private $client;
    private $argumentsGenerator;

    public function __construct(ClientProvider $client, DummyMethodArgumentsGenerator $argumentsGenerator)
    {
        $this->client = $client;
        $this->argumentsGenerator = $argumentsGenerator;
    }

    public function decode(string $method, SoapResponse $response)
    {
        $this->client->registerResponse($response);
        try {
            $decoded = $this->client->__soapCall($method, $this->argumentsGenerator->generateForSoapCall($method));
        } finally {
            $this->client->cleanUpTemporaryState();
        }
        return $decoded;
    }
}
