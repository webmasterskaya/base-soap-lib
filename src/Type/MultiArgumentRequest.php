<?php

namespace Webmasterskaya\Soap\Base\Type;

class MultiArgumentRequest implements MultiArgumentRequestInterface
{
    /**
     * @var array
     */
    private array $arguments;

    /**
     * @param   array  $arguments
     */
    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
    }


    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
