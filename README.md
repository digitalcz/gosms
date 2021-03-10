# gosms

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![CI](https://github.com/digitalcz/gosms/workflows/CI/badge.svg)]()
[![codecov](https://codecov.io/gh/digitalcz/gosms/branch/master/graph/badge.svg)](https://codecov.io/gh/digitalcz/gosms)
[![Total Downloads][ico-downloads]][link-downloads]

Provides communication with GoSMS.cz (see https://doc.gosms.cz/) in PHP via PSR-18 http client. 
Implemented standards PSR18 http client, PSR17 Discovery and PSR16 cache.

## Install

Via Composer

```bash
$ composer require digitalcz/gosms
```

## Configuration

Example configuration in Symfony
```yaml
#gosms.yaml for example
parameters:
    goSmsChannelId: '%env(int:GO_SMS_CHANNEL)%'

services:
    _defaults:
        autowire: true
        autoconfigure: true

    gosms_cache_provider:
        class: Symfony\Component\Cache\Psr16Cache
        arguments: ['@cache.app']

    DigitalCz\GoSms\Auth\AccessTokenProvider:
        arguments:
            - '@gosms_cache_provider'

    DigitalCz\GoSms\Auth\AccessTokenProviderInterface: '@DigitalCz\GoSms\Auth\AccessTokenProvider'

    DigitalCz\GoSms\GoSms:
        arguments:
            $clientId: '%env(GO_SMS_CLIENT_ID)%'
            $clientSecret: '%env(GO_SMS_CLIENT_SECRET)%'
```

## Usage

You can use DigitalCz\GoSms\Auth\AccessTokenProvider which use PSR6 CachingInterface (see https://www.php-fig.org/psr/psr-6/) for automatically store token.
Or you can implement your own by DigitalCz\GoSms\Auth\AccessTokenProviderInterface

Client used value objects for Requests and Responses. If you want working with your own objects, you can implement
DigitalCz\GoSms\Response\ResponseResolverInterface

```php
// access token provider via Symfony
$psr6Cache = new Symfony\Component\Cache\Adapter\FilesystemAdapter();
$psr16Cache = new Symfony\Component\Cache\Psr16Cache($psr6Cache);

$accessTokenProvider = new DigitalCz\GoSms\Auth\AccessTokenProvider(
    $psr16Cache
);

// GoSMS service
$goSmsService = new DigitalCz\GoSms\GoSms(
    'your_gosms_client_id',
    'your_gosms_secret_client_id',
    $accessTokenProvider
);

//return detail about organization DigitalCz\GoSms\ValueObject\DetailOrganization
$organizationDetail = $goSmsService->getDetailOrganization(); 

//send message via DigitalCz\GoSms\ValueObject\SendMessage
$message = new DigitalCz\GoSms\ValueObject\SendMessage('Hello Hans!', ['+420775300500'], 1);

//return DigitalCz\GoSms\ValueObject\SentMessage
$sentMessage = $goSmsService->sendMessage($message); 
$smsId = $sentMessage->getMessageId();

//return detail about message DigitalCz\GoSms\ValueObject\DetailMessage
$messageDetail = $goSmsService->detailMessage($smsId);  

//return replies of message DigitalCz\GoSms\ValueObject\RepliesMessage
$messageReplies = $goSmsService->repliesMessage($smsId);    

//delete message
$goSmsService->deleteMessage($smsId); 
```

#### Using your own http client
You can provide PSR18 http client (and PSR17 factories) when creating instance of classes, if no arguments are provided Psr18ClientDiscovery and Psr17FactoryDiscovery will be used (see https://php-http.readthedocs.io/en/latest/discovery.html).
```php
....
// example Symfony Psr18Client for RequestFactory
$symfonyHttpClient = Symfony\Component\HttpClient\Psr18Client();

$requestFactory = new DigitalCz\GoSms\Request\RequestFactory(
    $symfonyHttpClient, 
    $symfonyHttpClient   // symfony PSR18 client is also PSR17 factory
);
....
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

If you discover any security related issues, please email devs@digital.cz instead of using the issue tracker.

## Credits

- [Digital Solutions s.r.o.][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

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
