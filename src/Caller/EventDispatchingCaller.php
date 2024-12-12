<?php

namespace Webmasterskaya\Soap\Base\Caller;

use Psr\EventDispatcher\EventDispatcherInterface;
use Webmasterskaya\Soap\Base\Event;
use Webmasterskaya\Soap\Base\Exception\SoapException;
use Webmasterskaya\Soap\Base\Type\RequestInterface;
use Webmasterskaya\Soap\Base\Type\ResultInterface;

final readonly class EventDispatchingCaller implements CallerInterface
{
    public function __construct(
        private CallerInterface $caller,
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function __invoke(string $method, RequestInterface $request): ResultInterface
    {
        /** @var Event\RequestEvent $requestEvent */
        $requestEvent = $this->eventDispatcher->dispatch(new Event\RequestEvent($method, $request));
        $request      = $requestEvent->getRequest();

        try {
            $result = ($this->caller)($method, $request);
        } catch (SoapException $exception) {
            $this->eventDispatcher->dispatch(new Event\FaultEvent($exception, $requestEvent));
            throw $exception;
        }

        /** @var Event\ResponseEvent $responseEvent */
        $responseEvent = $this->eventDispatcher->dispatch(new Event\ResponseEvent($requestEvent, $result));

        return $responseEvent->getResponse();
    }
}
