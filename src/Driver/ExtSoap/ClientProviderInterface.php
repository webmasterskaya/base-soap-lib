<?php

namespace Webmasterskaya\Soap\Base\Driver\ExtSoap;

interface ClientProviderInterface
{
    public function SoapClient($wsdl = null, array $options = null);

    public function __construct($wsdl = null, array $options = null);

    public function __call($name, array $args);

    public function __soapCall($name, array $args, $options = null, $inputHeaders = null, &$outputHeaders = null);

    public function __getLastRequest(): ?string;

    public function __getLastResponse(): ?string;

    public function __getLastRequestHeaders(): ?string;

    public function __getLastResponseHeaders(): ?string;

    public function __getFunctions(): ?array;

    public function __getTypes(): ?array;

    public function __getCookies(): array;

    public function __doRequest($request, $location, $action, $version, $oneWay = false): ?string;

    public function __setCookie($name, $value): void;

    public function __setLocation($location = ''): ?string;

    public function __setSoapHeaders($headers = null): bool;
}