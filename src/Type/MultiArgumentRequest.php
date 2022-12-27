<?php

namespace Webmasterskaya\Soap\Base\Type;

class MultiArgumentRequest implements MultiArgumentRequestInterface
{
    /**
     * @var array
     */
    private $arguments;

    /**
     * MultiArgumentRequest constructor.
     *
     */
    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
    }


    public function getArguments(): array
    {
        return $this->arguments;
    }
}
