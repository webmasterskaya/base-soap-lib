<?php

namespace Webmasterskaya\Soap\Base;

use Soap\ExtSoapEngine\ExtSoapOptions;

interface ClientInterface
{
    public function __construct(ExtSoapOptions $options);
}
