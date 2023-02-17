<?php

namespace Webmasterskaya\Soap\Base;

use Exception;
use Soap\Engine\Engine;
use Soap\Engine\Transport;
use Soap\ExtSoapEngine\ExtSoapOptions;
use Webmasterskaya\Soap\Base\Exception\SoapException;
use Webmasterskaya\Soap\Base\Soap\DefaultEngineFactory;
use Webmasterskaya\Soap\Base\Soap\Metadata\MetadataOptions;
use Webmasterskaya\Soap\Base\Type\MixedResult;
use Webmasterskaya\Soap\Base\Type\MultiArgumentRequestInterface;
use Webmasterskaya\Soap\Base\Type\RequestInterface;
use Webmasterskaya\Soap\Base\Type\ResultInterface;
use Webmasterskaya\Soap\Base\Type\ResultProviderInterface;

abstract class ClientAbstract implements ClientInterface
{
    /**
     * @var Engine
     */
    protected $engine;

    /**
     * @var array
     */
    protected $defaults = [];

    public function __construct(
        ExtSoapOptions $options,
        ?Transport $transport = null,
        ?MetadataOptions $metadataOptions = null
    ) {
        $options = ExtSoapOptions::defaults(
            $options->getWsdl(),
            array_merge(
                $this->defaults,
                $options->getOptions()
            )
        );

        $this->engine = DefaultEngineFactory::create($options, $transport, $metadataOptions);
    }

    public function call(string $method, RequestInterface $request): ResultInterface
    {
        try {
            $arguments = ($request instanceof MultiArgumentRequestInterface) ? $request->getArguments() : [$request];
            $result = $this->engine->request($method, $arguments);

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
