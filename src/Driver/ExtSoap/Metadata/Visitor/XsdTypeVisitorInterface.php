<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Driver\ExtSoap\Metadata\Visitor;

use Soap\Engine\Metadata\Model\XsdType;

interface XsdTypeVisitorInterface
{
    public function __invoke(string $soapType): ?XsdType;
}
