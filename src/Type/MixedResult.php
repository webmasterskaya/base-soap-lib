<?php

namespace Webmasterskaya\Soap\Base\Type;

class MixedResult implements ResultInterface
{
    /**
     * @var mixed
     */
    private mixed $result;

    /**
     * MixedResult constructor.
     *
     * @param mixed $result
     */
    public function __construct(mixed $result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getResult(): mixed
    {
        return $this->result;
    }
}
