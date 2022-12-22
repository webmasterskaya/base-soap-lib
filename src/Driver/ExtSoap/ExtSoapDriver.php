<?php

namespace Webmasterskaya\Soap\Base\Driver\ExtSoap;

use Soap\Engine\Decoder;
use Soap\Engine\Driver;
use Soap\Engine\Encoder;
use Soap\Engine\HttpBinding\SoapRequest;
use Soap\Engine\HttpBinding\SoapResponse;
use Soap\Engine\Metadata\Metadata;

final class ExtSoapDriver implements Driver
{

    private $client;
    private $encoder;
    private $decoder;
    private $metadata;

    public function __construct(
        ClientProvider $client,
        Encoder $encoder,
        Decoder $decoder,
        Metadata $metadata
    ) {
        $this->client = $client;
        $this->encoder = $encoder;
        $this->decoder = $decoder;
        $this->metadata = $metadata;
    }

    public static function createFromOptions(ExtSoapOptions $options): self
    {
        $client = ClientProvider::createFromOptions($options);

        return self::createFromClient(
            $client,
            new LazyInMemoryMetadata(new ExtSoapMetadata($client))
        );
    }

    public function decode(string $method, SoapResponse $response)
    {
        // TODO: Implement decode() method.
    }

    public function encode(string $method, array $arguments): SoapRequest
    {
        // TODO: Implement encode() method.
    }

    public function getMetadata(): Metadata
    {
        // TODO: Implement getMetadata() method.
    }
}