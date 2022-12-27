<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Type;

final class MixedResult implements ResultInterface
{
    /**
     * @var mixed
     */
    private $result;

    /**
     * MixedResult constructor.
     *
     * @param mixed $result
     */
    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }
}
