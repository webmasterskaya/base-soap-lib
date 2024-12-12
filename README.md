# PHP SDK для разработки собственного SOAP клиента

[English version](./README_en.md)

Набор базовых классов для разработки собственного SOAP клиента.
Этот пакет помогает решить некоторые распространенные проблемы интеграции SOAP в PHP.

В состав проекта уже включены классы [`\Webmasterskaya\Soap\Base\Client`](src/Client.php) и [`\Webmasterskaya\Soap\Base\ClientFactory`](src/ClientFactory.php), готовые к запуску простого SOAP приложения.

Это реализация поверх [php-soap](https://github.com/php-soap). Для более продвинутой настройки вы можете ознакомиться с документацией пакетов в проекте [php-soap](https://github.com/php-soap).

## Установка

```shell
composer require webmasterskaya/base-soap-lib
```

## Простой пример использования

> [!NOTE]
> Для тестирования будем пользоваться demo SOAP APIs https://www.postman.com/cs-demo/public-soap-apis

```php
// Получаем экземпляр Client из ClientFactory передав ссылку на wsdl файл
$wsdlPath = 'https://www.dataaccess.com/webservicesserver/NumberConversion.wso?wsdl';
$client   = \Webmasterskaya\Soap\Base\ClientFactory::create($wsdlPath);

// Запрос должен быть объектом, который реализует RequestInterface
// Для демонстрации работы, мы создадим анонимный класс с необходимыми полями
$request = new class(300) implements \Webmasterskaya\Soap\Base\Type\RequestInterface {
    public function __construct(
        private readonly int $dNum
    ) {
    }
};

// Обращаемся к методу SOAP API, передав имя вызываемого метода и подготовленный объект запроса.
/** @var \Webmasterskaya\Soap\Base\Type\MixedResult $response */
$response = $client->call('NumberToDollars', $request);

// Проверяем результат
var_dump($response->getResult());
```

В ответе вы должны увидеть
```
object(stdClass)#50 (1) {
  ["NumberToDollarsResult"]=>
  string(21) "three hundred dollars"
}
```

## Настройка и запуск

### Создание собственного клиента

_...скоро будет..._

### Генерация собственного клиента

_...скоро будет..._