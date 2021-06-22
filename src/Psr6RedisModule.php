<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Psr\Cache\CacheItemPoolInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;
use Ray\PsrCacheModule\Annotation\CacheNamespace;
use Ray\PsrCacheModule\Annotation\Local;
use Ray\PsrCacheModule\Annotation\RedisConfig;
use Ray\PsrCacheModule\Annotation\RedisInstance;
use Ray\PsrCacheModule\Annotation\Shared;
use Symfony\Component\Cache\Adapter\RedisAdapter;

final class Psr6RedisModule extends AbstractModule
{
    /** @var array{0: string, 1:int} */
    private $server;

    /** @param array{0: string, 1:int} $server */
    public function __construct(array $server, ?AbstractModule $module = null)
    {
        $this->server = $server;
        parent::__construct($module);
    }

    protected function configure(): void
    {
        $this->bind(CacheItemPoolInterface::class)->annotatedWith(Local::class)->toProvider(LocalCacheProvider::class)->in(Scope::SINGLETON);
        $this->bind(CacheItemPoolInterface::class)->annotatedWith(Shared::class)->toConstructor(RedisAdapter::class, [
            'redisClient' => RedisInstance::class,
            'namespace' => CacheNamespace::class,
        ])->in(Scope::SINGLETON);
        $this->bind()->annotatedWith(RedisConfig::class)->toInstance($this->server);
        $this->bind('')->annotatedWith(RedisInstance::class)->toProvider(RedisProvider::class);
    }
}
