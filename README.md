# PHP SDK для разработки собственного SOAP клиента

[English version](./README_en.md)

Набор базовых классов для разработки собственного SOAP клиента без использования `ext-soap`.
Этот пакет помогает решить некоторые распространенные проблемы интеграции SOAP в PHP.

В состав проекта уже включены классы [`\Webmasterskaya\Soap\Base\Client`](src/Client.php) и [`\Webmasterskaya\Soap\Base\ClientFactory`](src/ClientFactory.php), готовые к запуску простого SOAP приложения.

Это реализация поверх [php-soap](https://github.com/php-soap). 
Для более продвинутой настройки вы можете ознакомиться с документацией пакетов в проекте [php-soap](https://github.com/php-soap).

## Установка

```shell
composer require webmasterskaya/base-soap-lib
```

## Простой пример использования

Смотрите в файле [./example/index.php](./example/index.php)