# PHP SDK for create self SOAP Client

[Русская версия](./README.md)

A set of base classes for developing your own SOAP client without using `ext-soap`. 
This package helps to solve some common integration problems with SOAP in PHP.

The project already includes the [`\Webmasterskaya\Soap\Base\Client`](src/Client.php) and [`\Webmasterskaya\Soap\Base\ClientFactory`](src/ClientFactory.php) classes, ready to run a simple SOAP application.

This is an implementation built on top of [php-soap](https://github.com/php-soap).
For more advanced configuration, you can refer to the documentation of the packages in the [php-soap](https://github.com/php-soap) project.

## Installation

```shell
composer require webmasterskaya/base-soap-lib
```

## Simple use

See to [./example/index.php](./example/index.php)