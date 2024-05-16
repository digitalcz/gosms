<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Dummy\Auth;

use Psr\SimpleCache\CacheInterface;

class InMemoryCache implements CacheInterface
{
    /**
     * @var array<mixed>
     */
    private array $cache = [];

    public function get(mixed $key, mixed $default = null): mixed
    {
        return $this->has($key) ? $this->cache[$key] : $default;
    }

    public function set(mixed $key, mixed $value, null|int|\DateInterval $ttl = null): bool // phpcs:ignore
    {
        $this->cache[$key] = $value;

        return true;
    }

    public function delete(mixed $key): bool
    {
        unset($this->cache[$key]);

        return true;
    }

    public function clear(): bool
    {
        $this->cache = [];

        return true;
    }

    /**
     * @param  array|mixed[] $keys
     * @return array|mixed[]
     */
    public function getMultiple(iterable $keys, mixed $default = null): array
    {
        $values = [];
        foreach ($keys as $key) {
            $values[$key] = $this->get($key, $default); // @phpstan-ignore-line
        }

        return $values;
    }

    /**
     * @param  array|mixed[] $values
     */
    public function setMultiple(iterable $values, null|int|\DateInterval $ttl = null): bool // phpcs:ignore
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }

        return true;
    }

    /**
     * @param  array|mixed[] $keys
     */
    public function deleteMultiple(iterable $keys): bool
    {
        foreach ($keys as $key) {
            $this->delete($key); // @phpstan-ignore-line
        }

        return true;
    }

    public function has(mixed $key): bool
    {
        return isset($this->cache[$key]);
    }
}
