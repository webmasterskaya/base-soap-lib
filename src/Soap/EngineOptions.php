<?php

namespace Webmasterskaya\Soap\Base\Soap;

use Psl\Option\Option;
use Psr\Cache\CacheItemPoolInterface;
use Soap\CachedEngine\CacheConfig;
use Soap\Encoding\EncoderRegistry;
use Soap\Engine\Transport;
use Soap\Psr18Transport\Psr18Transport;
use Soap\Wsdl\Loader\FlatteningLoader;
use Soap\Wsdl\Loader\StreamWrapperLoader;
use Soap\Wsdl\Loader\WsdlLoader;
use Soap\WsdlReader\Locator\ServiceSelectionCriteria;
use Soap\WsdlReader\Parser\Context\ParserContext;

use function Psl\Option\from_nullable;

final class EngineOptions
{
    /**
     * @var non-empty-string
     */
    private string $wsdl;
    private ?WsdlLoader $wsdlLoader = null;
    private ?Transport $transport = null;
    private ?CacheItemPoolInterface $cache = null;
    private ?CacheConfig $cacheConfig = null;
    private ?ParserContext $wsdlParserContext = null;
    private ?EncoderRegistry $encoderRegistry = null;
    private ?ServiceSelectionCriteria $wsdlServiceSelectionCriteria = null;

    /**
     * @param non-empty-string $wsdl
     */
    private function __construct(string $wsdl)
    {
        $this->wsdl = $wsdl;
    }

    /**
     * @param non-empty-string $wsdl
     */
    public static function defaults(string $wsdl): self
    {
        return new self($wsdl);
    }

    public function withCache(CacheItemPoolInterface $cache, ?CacheConfig $config = null): self
    {
        $clone = clone $this;
        $clone->cache = $cache;
        $clone->cacheConfig = $config;

        return $clone;
    }

    public function withWsdlLoader(WsdlLoader $loader): self
    {
        $clone = clone $this;
        $clone->wsdlLoader = $loader;

        return $clone;
    }

    public function withWsdlParserContext(ParserContext $parserContext): self
    {
        $clone = clone $this;
        $clone->wsdlParserContext = $parserContext;

        return $clone;
    }

    public function withTransport(Transport $transport): self
    {
        $clone = clone $this;
        $clone->transport = $transport;

        return $clone;
    }

    public function withEncoderRegistry(EncoderRegistry $registry): self
    {
        $clone = clone $this;
        $clone->encoderRegistry = $registry;

        return $clone;
    }

    public function withWsdlServiceSelectionCriteria(ServiceSelectionCriteria $criteria): self
    {
        $clone = clone $this;
        $clone->wsdlServiceSelectionCriteria = $criteria;

        return $clone;
    }

    /**
     * @return non-empty-string
     */
    public function getWsdl(): string
    {
        return $this->wsdl;
    }

    public function getWsdlLoader(): WsdlLoader
    {
        return $this->wsdlLoader ?? new FlatteningLoader(new StreamWrapperLoader());
    }

    public function getWsdlParserContext(): ParserContext
    {
        return $this->wsdlParserContext ?? ParserContext::defaults();
    }

    public function getTransport(): Transport
    {
        return $this->transport ?? Psr18Transport::createWithDefaultClient();
    }

    /**
     * @return Option<CacheItemPoolInterface>
     */
    public function getCache(): Option
    {
        return from_nullable($this->cache);
    }

    public function getCacheConfig(): CacheConfig
    {
        return $this->cacheConfig ?? new CacheConfig('soap-driver-'.md5($this->wsdl));
    }

    public function getWsdlServiceSelectionCriteria(): ServiceSelectionCriteria
    {
        return ($this->wsdlServiceSelectionCriteria ?? ServiceSelectionCriteria::defaults())
            // HTTP ports are not supported in this SOAP-client
            ->withAllowHttpPorts(false);
    }

    public function getEncoderRegistry(): EncoderRegistry
    {
        return $this->encoderRegistry ?? EncoderRegistry::default();
    }
}
