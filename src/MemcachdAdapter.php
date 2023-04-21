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

/** @psalm-suppress PropertyNotSetInConstructor */
class MemcachdAdapter extends OriginAdapter implements Serializable
{
    use SerializableTrait;

    /**
     * @param ProviderInterface<Memcached> $clientProvider
     *
     * @Named("memcached")
     * @CacheNamespace("namespace")
     */
    #[CacheNamespace('namespace')]
    #[Named('memcached')]
    public function __construct(ProviderInterface $clientProvider, string $namespace = '', int $defaultLifetime = 0, ?MarshallerInterface $marshaller = null)
    {
        $this->args = func_get_args();

        parent::__construct($clientProvider->get(), $namespace, $defaultLifetime, $marshaller);
    }
}
