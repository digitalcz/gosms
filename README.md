# gosms

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![CI](https://github.com/digitalcz/gosms/workflows/CI/badge.svg)]()
[![codecov](https://codecov.io/gh/digitalcz/gosms/branch/master/graph/badge.svg)](https://codecov.io/gh/digitalcz/gosms)
[![Total Downloads][ico-downloads]][link-downloads]

[GoSms](https://github.com/digitalcz/gosms) PHP library - provides communication with https://doc.gosms.cz in PHP using PSR-18 HTTP Client, PSR-17 HTTP Factories and PSR-16 SimpleCache.

## Install

Via [Composer](https://getcomposer.org/)

```bash
$ composer require digitalcz/gosms
```

## Configuration

#### Example configuration in PHP

```php
use DigitalCz\GoSms\Auth\ApiKeyCredentials;
use DigitalCz\GoSms\GoSms;

// Via constructor options
$goSms = new GoSms([
    'client_id' => '...', 
    'client_secret' => '...'
]);

// Or via methods
$goSms = new GoSms();
$goSms->setCredentials(new ApiKeyCredentials('...', '...'));
```

#### Available constructor options
*  `client_id`           - string; ApiKey client_id key
*  `client_secret`       - string; ApiKey client_secret key
*  `credentials`         - DigitalCz\GoSms\Auth\Credentials instance
*  `client`              - DigitalCz\GoSms\GoSmsClient instance with your custom PSR17/18 objects
*  `http_client`         - Psr\Http\Client\ClientInterface instance of your custom PSR18 client
*  `cache`               - Psr\SimpleCache\CacheInterface for caching Credentials Tokens
*  `api_base`            - string; override the base API url

#### Available configuration methods

```php
use DigitalCz\GoSms\Auth\Token;
use DigitalCz\GoSms\Auth\TokenCredentials;
use DigitalCz\GoSms\GoSms;
use DigitalCz\GoSms\GoSmsClient;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Symfony\Component\HttpClient\Psr18Client;

$goSms = new GoSms();
// To set your own PSR-18 HTTP Client, if not provided Psr18ClientDiscovery is used
$goSms->setClient(new GoSmsClient(new Psr18Client()));
// If you already have the auth-token, i can use TokenCredentials
$goSms->setCredentials(new TokenCredentials(new Token('...', 123)));
// Cache will be used to store auth-token, so it can be reused in later requests
$goSms->setCache(new Psr16Cache(new FilesystemAdapter()));
// Overwrite API base
$goSms->setApiBase('https://example.com/api');
```

#### Example configuration in Symfony

```yaml
services:
  DigitalCz\GoSms\GoSms:
    $options:
      # minimal config
      access_key: '%gosms.client_id%'
      secret_key: '%gosms.client_secret%'
      
      # other options
      cache: '@psr16.cache'
      http_client: '@psr18.http_client'
```

## Usage

#### Create and send Message

```php
$goSms = new DigitalCz\GoSms\GoSms(['client_id' => '...', 'client_secret' => '...']);

$organization = $goSms->organization()->detail();

echo "Detail organization " . var_dump($organization) . PHP_EOL;

$messages = $goSms->messages();

$message = $messages->create(
    [
        'message' => 'Hello Hans, please call me back.',
        'recipients' => '+420775300500',
        'channel' => 6,
    ],
);
echo "Created Message " . $message->link() . PHP_EOL;

$message = $messages->get('example_message_id');
echo "Detail Message " . var_dump($message) . PHP_EOL;

$messages->delete('example_message_id');
echo "Message was deleted " . PHP_EOL;

```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer csfix    # fix codestyle
$ composer checks   # run all checks 

# or separately
$ composer tests    # run phpunit
$ composer phpstan  # run phpstan
$ composer cs       # run codesniffer
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
[ico-downloads]: https://img.shields.io/packagist/dt/digitalcz/gosms.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/digitalcz/gosms
[link-downloads]: https://packagist.org/packages/digitalcz/gosms
[link-author]: https://github.com/digitalcz
[link-contributors]: ../../contributors

