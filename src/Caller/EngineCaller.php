<?php

namespace Webmasterskaya\Soap\Base\Caller;

use Exception;
use Soap\Engine\Engine;
use Webmasterskaya\Soap\Base\Exception\SoapException;
use Webmasterskaya\Soap\Base\Type\MixedResult;
use Webmasterskaya\Soap\Base\Type\MultiArgumentRequestInterface;
use Webmasterskaya\Soap\Base\Type\RequestInterface;
use Webmasterskaya\Soap\Base\Type\ResultInterface;
use Webmasterskaya\Soap\Base\Type\ResultProviderInterface;

final readonly class EngineCaller implements CallerInterface
{
    public function __construct(
        private Engine $engine
    ) {
    }

    public function __invoke(string $method, RequestInterface $request): ResultInterface
    {
        try {
            $arguments = ($request instanceof MultiArgumentRequestInterface) ? $request->getArguments() : [$request];
            $result    = $this->engine->request($method, $arguments);

            if ($result instanceof ResultProviderInterface) {
                $result = $result->getResult();
            }

            if (!$result instanceof ResultInterface) {
                $result = new MixedResult($result);
            }
        } catch (Exception $exception) {
            throw SoapException::fromThrowable($exception);
        }

        return $result;
    }
}
