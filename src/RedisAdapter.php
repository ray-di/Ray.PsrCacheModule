<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Ray\Di\Di\Named;
use Ray\Di\ProviderInterface;
use Ray\PsrCacheModule\Annotation\CacheNamespace;
use Redis;
use Serializable;
use Symfony\Component\Cache\Adapter\RedisAdapter as OriginAdapter;
use Symfony\Component\Cache\Marshaller\MarshallerInterface;

use function func_get_args;

/** @psalm-suppress PropertyNotSetInConstructor */
class RedisAdapter extends OriginAdapter implements Serializable
{
    use SerializableTrait;

    /**
     * @param ProviderInterface<Redis> $redisProvider
     *
     * @CacheNamespace("namespace")
     * @Named("redisProvider=redis")
     */
    #[CacheNamespace('namespace')]
    #[Named('redisProvider=redis')]
    public function __construct(ProviderInterface $redisProvider, string $namespace = '', int $defaultLifetime = 0, ?MarshallerInterface $marshaller = null)
    {
        $this->args = func_get_args();

        parent::__construct($redisProvider->get(), $namespace, $defaultLifetime, $marshaller);
    }
}
