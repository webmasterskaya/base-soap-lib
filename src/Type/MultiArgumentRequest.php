<?php

declare(strict_types=1);

namespace Webmasterskaya\Soap\Base\Type;

final class MultiArgumentRequest implements MultiArgumentRequestInterface
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
