<?php

use Http\Client\Common\PluginClient;
use Http\Discovery\Psr18ClientDiscovery;
use Soap\Encoding\EncoderRegistry;
use Soap\Psr18Transport\Middleware\Wsdl\DisableExtensionsMiddleware;
use Soap\Psr18Transport\Middleware\Wsdl\DisablePoliciesMiddleware;
use Soap\Psr18Transport\Psr18Transport;
use Soap\Psr18Transport\Wsdl\Psr18Loader;
use Webmasterskaya\Soap\Base\ClientFactory;
use Webmasterskaya\Soap\Base\Example\NumberToWordsRequest;
use Webmasterskaya\Soap\Base\Example\NumberToWordsResponse;
use Webmasterskaya\Soap\Base\Soap\EngineOptions;

require_once dirname(__DIR__) . '/vendor/autoload.php';

require_once dirname(__FILE__) . '/src/NumberToWordsRequest.php';
require_once dirname(__FILE__) . '/src/NumberToWordsResponse.php';

$psr18client = new PluginClient(
    Psr18ClientDiscovery::find(),
    [
        new DisablePoliciesMiddleware(),
        new DisableExtensionsMiddleware(),
    ],
);

$wsdl = 'https://www.dataaccess.com/webservicesserver/NumberConversion.wso?wsdl';

$options = EngineOptions::defaults($wsdl)
    ->withTransport(Psr18Transport::createForClient($psr18client))
    ->withWsdlLoader(Psr18Loader::createForClient($psr18client))
    ->withEncoderRegistry(
        EncoderRegistry::default()
            ->addClassMap(
                'http://www.dataaccess.com/webservicesserver/',
                'NumberToWordsResponse',
                NumberToWordsResponse::class
            )
    );

$client = ClientFactory::create($wsdl, $options);

/** @var NumberToWordsResponse $response */
$response = $client->call(
    'NumberToWords',
    new NumberToWordsRequest(321),
);

echo $response->getNumberToWordsResult(); // three hundred and twenty one
