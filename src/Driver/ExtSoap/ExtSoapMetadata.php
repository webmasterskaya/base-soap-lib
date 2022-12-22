<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Driver\ExtSoap;

use Soap\Engine\Metadata\Collection\MethodCollection;
use Soap\Engine\Metadata\Collection\TypeCollection;
use Soap\Engine\Metadata\Collection\XsdTypeCollection;
use Soap\Engine\Metadata\Metadata;
use Webmasterskaya\Soap\Base\Driver\ExtSoap\Metadata\MethodsParser;
use Webmasterskaya\Soap\Base\Driver\ExtSoap\Metadata\TypesParser;
use Webmasterskaya\Soap\Base\Driver\ExtSoap\Metadata\XsdTypesParser;

final class ExtSoapMetadata implements Metadata
{
    private $clientProvider;
    private $xsdTypes = null;

    public function __construct(ClientProvider $clientProvider)
    {
        $this->clientProvider = $clientProvider;
    }

    public function getMethods(): MethodCollection
    {
        return (new MethodsParser($this->getXsdTypes()))->parse($this->clientProvider);
    }

    public function getTypes(): TypeCollection
    {
        return (new TypesParser($this->getXsdTypes()))->parse($this->clientProvider);
    }

    private function getXsdTypes(): XsdTypeCollection
    {
        if (null === $this->xsdTypes) {
            $this->xsdTypes = XsdTypesParser::default()->parse($this->clientProvider);
        }

        return $this->xsdTypes;
    }
}
