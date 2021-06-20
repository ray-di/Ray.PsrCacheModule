<?php

declare(strict_types=1);

namespace BEAR\PsrCache;

use BEAR\PsrCache\Annotation\CacheNameSpace;
use BEAR\PsrCache\Annotation\RedisConfig;
use BEAR\PsrCache\Annotation\RedisInstance;
use BEAR\PsrCache\Annotation\Shared;
use Psr\Cache\CacheItemPoolInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;
use Symfony\Component\Cache\Adapter\ApcuAdapter;
use Symfony\Component\Cache\Adapter\RedisAdapter;

final class RedisCacheModule extends AbstractModule
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
        $this->bind(CacheItemPoolInterface::class)->toConstructor(ApcuAdapter::class, [
            'namespace' => CacheNameSpace::class,
        ]);
        $this->bind(CacheItemPoolInterface::class)->annotatedWith(Shared::class)->toConstructor(RedisAdapter::class, [
            'redisClient' => RedisInstance::class,
            'namespace' => CacheNameSpace::class,
        ])->in(Scope::SINGLETON);
        $this->bind()->annotatedWith(RedisConfig::class)->toInstance($this->server);
        $this->bind('')->annotatedWith(RedisInstance::class)->toProvider(RedisProvider::class);
    }
}
