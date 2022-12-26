<?php

namespace Webmasterskaya\Soap\Base;

use Soap\Engine\Engine;
use Soap\ExtSoapEngine\ExtSoapOptions;

interface ClientInterface
{
    public function __construct(ExtSoapOptions $options);
}