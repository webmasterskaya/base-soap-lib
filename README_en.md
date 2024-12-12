# PHP SDK for create self SOAP Client

[Русская версия](./README.md)

A set of base classes for developing your own SOAP client. This package helps to solve some common integration problems with SOAP in PHP.
This is an implementation built on top of php-soap (https://github.com/php-soap). For more advanced configuration, you can refer to the documentation of the packages in the php-soap (https://github.com/php-soap) project.

The project already includes the [`\Webmasterskaya\Soap\Base\Client`](src/Client.php) and [`\Webmasterskaya\Soap\Base\ClientFactory`](src/ClientFactory.php) classes, ready to run a simple SOAP application.

## Installation

```shell
composer require webmasterskaya/base-soap-lib
```

## Simple use

> [!NOTE]
> For testing we use this demo SOAP APIs https://www.postman.com/cs-demo/public-soap-apis

```php
// Get Client instance from ClientFactory with wsdl file by link
$wsdlPath = 'https://www.dataaccess.com/webservicesserver/NumberConversion.wso?wsdl';
$client   = \Webmasterskaya\Soap\Base\ClientFactory::create($wsdlPath);

// The request must be an object that implements the RequestInterface
// To demonstrate the work, we create anonymous class with the necessary fields
$request = new class(300) implements \Webmasterskaya\Soap\Base\Type\RequestInterface {
    public function __construct(
        private readonly int $dNum
    ) {
    }
};

// We call the SOAP API method, pass the method name and the prepared request object to the client.
/** @var \Webmasterskaya\Soap\Base\Type\MixedResult $response */
$response = $client->call('NumberToDollars', $request);

// Check response
var_dump($response->getResult());
```

You will see in the response
```
object(stdClass)#50 (1) {
  ["NumberToDollarsResult"]=>
  string(21) "three hundred dollars"
}
```

## Configuration and Launch

### Creating Your Own Client

_...coming soon..._

### Generating Your Own Client

_...coming soon..._