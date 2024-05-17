<?php

declare(strict_types=1);

namespace DigitalCz\GoSms;

use DigitalCz\GoSms\Auth\ApiKeyCredentials;
use DigitalCz\GoSms\Auth\CachedCredentials;
use DigitalCz\GoSms\Auth\Credentials;
use DigitalCz\GoSms\Endpoint\AuthEndpoint;
use DigitalCz\GoSms\Endpoint\EndpointInterface;
use DigitalCz\GoSms\Endpoint\MessagesEndpoint;
use DigitalCz\GoSms\Endpoint\OrganizationEndpoint;
use InvalidArgumentException;
use LogicException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\CacheInterface;

final class GoSms implements EndpointInterface
{
    public const VERSION = '2.0.0';
    public const API_BASE = 'https://app.gosms.cz';

    /** The base URL for requests */
    private string $apiBase = self::API_BASE;

    /** The credentials used to authenticate to API */
    private Credentials $credentials;

    /** The client used to send requests */
    private GoSmsClientInterface $client;

    /** @var array<string, string> */
    private array $versions = [];

    /**
     * Available options:
     *  client_id           - string; ApiKey access key
     *  client_secret       - string; ApiKey secret key
     *  credentials         - DigitalCz\GoSms\Auth\Credentials instance
     *  client              - DigitalCz\GoSms\GoSmsClient instance with your custom PSR17/18 objects
     *  http_client         - Psr\Http\Client\ClientInterface instance of your custom PSR18 client
     *  cache               - Psr\SimpleCache\CacheInterface for caching Credentials auth Tokens
     *  api_base            - string; override the base API url
     *
     * @param array{
     *      client_id?: string,
     *      client_secret?: string,
     *      credentials?: Credentials,
     *      client?: GoSmsClient,
     *      http_client?: ClientInterface,
     *      cache?: CacheInterface,
     *      testing?: bool,
     *      api_base?: string,
     *      signature_tolerance?: int
     * } $options
     */
    public function __construct(array $options = [])
    {
        $httpClient = $options['http_client'] ?? null;
        $this->setClient($options['client'] ?? new GoSmsClient($httpClient));
        $this->addVersion('digitalcz/gosms', self::VERSION);
        $this->addVersion('PHP', PHP_VERSION);

        if (isset($options['api_base'])) {
            if (!is_string($options['api_base'])) {
                throw new InvalidArgumentException('Invalid value for "api_base" option');
            }

            $this->setApiBase($options['api_base']);
        }

        if (isset($options['client_id'], $options['client_secret'])) {
            $this->setCredentials(new ApiKeyCredentials($options['client_id'], $options['client_secret']));
        }

        if (isset($options['credentials'])) {
            if (!$options['credentials'] instanceof Credentials) {
                throw new InvalidArgumentException('Invalid value for "credentials" option');
            }

            $this->setCredentials($options['credentials']);
        }

        // if cache is provided, wrap Credentials with cache decorator
        if (isset($options['cache'])) {
            if (!$options['cache'] instanceof CacheInterface) {
                throw new InvalidArgumentException('Invalid value for "cache" option');
            }

            $this->setCache($options['cache']);
        }
    }

    public function setCache(CacheInterface $cache): void
    {
        $credentials = $this->getCredentials();

        // if credentials are already decorated, do not double wrap, but get inner
        if ($credentials instanceof CachedCredentials) {
            $credentials = $credentials->getInner();
        }

        $this->setCredentials(new CachedCredentials($credentials, $cache));
    }

    public function getCredentials(): Credentials
    {
        if (!isset($this->credentials)) {
            throw new LogicException(
                'No credentials were provided, Please use setCredentials() ' .
                'or constructor options to set them.',
            );
        }

        return $this->credentials;
    }

    public function setCredentials(Credentials $credentials): void
    {
        $this->credentials = $credentials;
    }

    public function setClient(GoSmsClientInterface $client): void
    {
        $this->client = $client;
    }

    public function setApiBase(string $apiBase): void
    {
        $this->apiBase = rtrim(trim($apiBase), '/');
    }

    public function addVersion(string $tool, string $version = ''): void
    {
        $this->versions[$tool] = $version;
    }

    public function removeVersion(string $tool): void
    {
        unset($this->versions[$tool]);
    }

    /** @inheritDoc */
    public function request(string $method, string $path = '', array $options = []): ResponseInterface
    {
        $options['user-agent'] = $this->createUserAgent();

        // disable authorization header if options[no_auth]=true
        if (($options['no_auth'] ?? false) !== true) {
            $options['auth_bearer'] ??= $this->createBearer();
        }

        return $this->client->request($method, $this->apiBase . $path, $options);
    }

    public function auth(): AuthEndpoint
    {
        return new AuthEndpoint($this);
    }

    public function organization(): OrganizationEndpoint
    {
        return new OrganizationEndpoint($this);
    }

    public function messages(): MessagesEndpoint
    {
        return new MessagesEndpoint($this);
    }

    private function createUserAgent(): string
    {
        $userAgent = '';

        foreach ($this->versions as $tool => $version) {
            $userAgent .= $tool;
            $userAgent .= $version !== '' ? ":$version" : '';
            $userAgent .= ' ';
        }

        return $userAgent;
    }

    private function createBearer(): string
    {
        return $this->getCredentials()->provide($this)->getToken();
    }
}
