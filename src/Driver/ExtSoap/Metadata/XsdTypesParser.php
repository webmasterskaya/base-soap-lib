<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Driver\ExtSoap\Metadata;

use Soap\Engine\Metadata\Collection\XsdTypeCollection;
use Soap\Engine\Metadata\Model\XsdType;
use Webmasterskaya\Soap\Base\Driver\ExtSoap\ClientProviderInterface;
use Webmasterskaya\Soap\Base\Driver\ExtSoap\Metadata\Visitor\ListVisitor;
use Webmasterskaya\Soap\Base\Driver\ExtSoap\Metadata\Visitor\SimpleTypeVisitor;
use Webmasterskaya\Soap\Base\Driver\ExtSoap\Metadata\Visitor\UnionVisitor;
use Webmasterskaya\Soap\Base\Driver\ExtSoap\Metadata\Visitor\XsdTypeVisitorInterface;

final class XsdTypesParser
{
    /**
     * @var XsdTypeVisitorInterface[]
     */
    private $visitors;

    public function __construct(XsdTypeVisitorInterface ...$visitors)
    {
        $this->visitors = $visitors;
    }

    public static function default(): self
    {
        return new self(
            new ListVisitor(),
            new UnionVisitor(),
            new SimpleTypeVisitor()
        );
    }

    public function parse(ClientProviderInterface $client): XsdTypeCollection
    {
        $collected = [];
        $soapTypes = (array)$client->__getTypes();
        foreach ($soapTypes as $soapType) {
            if ($type = $this->detectXsdType($soapType)) {
                $collected[] = $type;
            }
        }

        return new XsdTypeCollection(...$collected);
    }

    private function detectXsdType(string $soapType): ?XsdType
    {
        foreach ($this->visitors as $visitor) {
            if ($type = $visitor($soapType)) {
                return $type;
            }
        }

        return null;
    }
}
