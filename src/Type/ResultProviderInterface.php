<?php

namespace Webmasterskaya\Soap\Base\Type;

interface ResultProviderInterface
{
    /**
     * @return ResultInterface
     */
    public function getResult(): ResultInterface;
}
