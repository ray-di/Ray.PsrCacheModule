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
use Redis;
use RuntimeException;

use function class_exists;
use function explode;

final class Psr6RedisModule extends AbstractModule
{
    /** @var list<string> */
    private $server;

    public function __construct(string $server, ?AbstractModule $module = null)
    {
        $this->server = explode(':', $server);

        parent::__construct($module);
    }

    protected function configure(): void
    {
        if (! class_exists(Redis::class)) {
            // @codeCoverageIgnoreStart
            throw new RuntimeException('Redis not installed.');
            // @codeCoverageIgnoreEnd
        }

        $this->bind(Redis::class);
        $this->bind(CacheItemPoolInterface::class)->annotatedWith(Local::class)->toConstructor(ApcuAdapter::class, ['namespace' => CacheNamespace::class])->in(Scope::SINGLETON);
        $this->bind(CacheItemPoolInterface::class)->annotatedWith(Shared::class)->toConstructor(RedisAdapter::class, [
            'redis' => RedisInstance::class,
            'namespace' => CacheNamespace::class,
        ]);
        $this->bind()->annotatedWith(RedisConfig::class)->toInstance($this->server);
        $this->bind('')->annotatedWith(RedisInstance::class)->toProvider(RedisProvider::class);
    }
}
