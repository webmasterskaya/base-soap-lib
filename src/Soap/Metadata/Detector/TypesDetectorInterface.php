<?php


namespace Webmasterskaya\Soap\Base\Soap\Metadata\Detector;

use Soap\Engine\Metadata\Collection\MethodCollection;

interface TypesDetectorInterface
{
    public function __invoke(MethodCollection $methods): array;
}
