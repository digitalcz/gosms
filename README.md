# gosms

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Provides communication with https://doc.gosms.cz/ in PHP via PSR-18 http client.
Used own token provider for automatically storage Token between api communication.

## Install

Via Composer

```bash
$ composer require digitalcz/gosms
```

## Usage

```php
$goSmsService = new DigitalCz\GoSms\GoSms($client, $requestFactory, $responseObjectFactory);

$organizationDetail = $goSmsService->getDetailOrganization(); //return info about account

$message = new DigitalCz\GoSms\ValueObject\SendMessage('Hello Hans!', ['+420775300500'], 1);
$smsId = $goSmsService->sendMessage($message); //send message

$messageDetail = $goSmsService->detailMessage($smsId);    //return detail about message DigitalCz\GoSms\ValueObject\DetailMessage
$messageReplies = $goSmsService->repliesMessage($smsId);    //return replies of message DigitalCz\GoSms\ValueObject\RepliesMessage

$goSmsService->deleteMessage($smsId); //delete message
```

#### Using your own http client

You can provide PSR18 http client (and PSR17 factories) when creating instance of classes, if no arguments are provided Psr18ClientDiscovery and Psr17FactoryDiscovery will be used (see https://php-http.readthedocs.io/en/latest/discovery.html).
```php
// example
$symfonyHttpClient = Symfony\Component\HttpClient\Psr18Client();

$factory = new DigitalCz\GoSms\Request\RequestFactory(
    $symfonyHttpClient, 
    $symfonyHttpClient   // symfony PSR18 client is also PSR17 factory
);
```

You can provide PSR6 Caching Interface (see https://www.php-fig.org/psr/psr-6/) when create Access Token provider for store token.
```php
// example
$psr6Cache = new Symfony\Component\Cache\Adapter\FilesystemAdapter();
$psr16Cache = new Symfony\Component\Cache\Psr16Cache($psr6Cache);

$register = new DigitalCz\GoSms\Auth\AccessTokenProvider(
    $psr16Cache
);

//or you can implemented your own by AccessTokenProviderInterface
```

Configuration in Symfony
```yaml
#gosms.yaml for example
parameters:
    goSmsChannelId: '%env(int:GO_SMS_CHANNEL)%'

services:
    gosms_cache_provider:
        class: Symfony\Component\Cache\Psr16Cache
        arguments: ['@cache.app']

    DigitalCz\GoSms\ValueObject\ClientCredentials:
        arguments:
            $clientId: '%env(GO_SMS_CLIENT_ID)%'
            $clientSecret: '%env(GO_SMS_CLIENT_SECRET)%'

    DigitalCz\GoSms\Auth\AccessTokenProvider:
        arguments:
            - '@gosms_cache_provider'

    DigitalCz\GoSms\Response\ResponseObjectFactory: ~

    DigitalCz\GoSms\Request\RequestFactory:
        arguments:
            - '@psr18.http_client'
            - '@psr18.http_client'

    DigitalCz\GoSms\Http\Client:
        arguments:
            - '@DigitalCz\GoSms\ValueObject\ClientCredentials'
            - '@Psr\Http\Client\ClientInterface'
            - '@DigitalCz\GoSms\Auth\AccessTokenProvider'
            - '@DigitalCz\GoSms\Request\RequestFactory'
            - '@DigitalCz\GoSms\Response\ResponseObjectFactory'

    DigitalCz\GoSms\GoSms:
        arguments:
            - '@DigitalCz\GoSms\Http\Client'
            - '@DigitalCz\GoSms\Request\RequestFactory'
            - '@DigitalCz\GoSms\Response\ResponseObjectFactory'
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer tests
$ composer phpstan
$ composer cs       # codesniffer
$ composer csfix    # code beautifier
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email info@digital.cz instead of using the issue tracker.

## Credits

- [Digital Solutions s.r.o.][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/digitalcz/gosms.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/digitalcz/gosms/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/digitalcz/gosms.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/digitalcz/gosms.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/digitalcz/gosms.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/digitalcz/gosms
[link-travis]: https://travis-ci.org/digitalcz/gosms
[link-scrutinizer]: https://scrutinizer-ci.com/g/digitalcz/gosms/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/digitalcz/gosms
[link-downloads]: https://packagist.org/packages/digitalcz/gosms
[link-author]: https://github.com/digitalcz
[link-contributors]: ../../contributors