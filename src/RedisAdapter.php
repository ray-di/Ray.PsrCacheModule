<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Ray\Di\Di\Named;
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
     * @param Redis $redis
     *
     * @CacheNamespace("namespace")
     * @Named("redis=Ray\PsrCacheModule\Annotation\RedisInstance")
     */
    #[CacheNamespace('namespace')]
    #[Named('redis=Ray\PsrCacheModule\Annotation\RedisInstance')]
    public function __construct($redis, string $namespace = '', int $defaultLifetime = 0, ?MarshallerInterface $marshaller = null)
    {
        $this->args = func_get_args();

        parent::__construct($redis, $namespace, $defaultLifetime, $marshaller);
    }
}
