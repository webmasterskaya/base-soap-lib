<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Type;

interface ResultProviderInterface
{
    public function getResult(): ResultInterface;
}
