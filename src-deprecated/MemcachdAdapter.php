<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Memcached;
use Ray\Di\Di\Named;
use Ray\Di\ProviderInterface;
use Ray\PsrCacheModule\Annotation\CacheNamespace;
use Serializable;
use Symfony\Component\Cache\Adapter\MemcachedAdapter as OriginAdapter;
use Symfony\Component\Cache\Marshaller\MarshallerInterface;

use function func_get_args;

/** @deprecated Use \Ray\PsrCacheModule\MemcachedAdapter instead */
class MemcachdAdapter extends OriginAdapter implements Serializable
{
    use SerializableTrait;

    public function __construct(MemcachedProvider $provider, string $namespace = '', int $defaultLifetime = 0, ?MarshallerInterface $marshaller = null)
    {
        $this->args = func_get_args();

        parent::__construct($provider->get(), $namespace, $defaultLifetime, $marshaller);
    }
}
