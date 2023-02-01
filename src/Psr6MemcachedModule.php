<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Memcached;
use Psr\Cache\CacheItemPoolInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;
use Ray\PsrCacheModule\Annotation\CacheNamespace;
use Ray\PsrCacheModule\Annotation\Local;
use Ray\PsrCacheModule\Annotation\MemcacheConfig;
use Ray\PsrCacheModule\Annotation\Shared;
use Symfony\Component\Cache\Adapter\MemcachedAdapter;

use function array_map;
use function explode;

final class Psr6MemcachedModule extends AbstractModule
{
    /** @var list<list<string>> */
    private $servers;

    public function __construct(string $servers, ?AbstractModule $module = null)
    {
        $this->servers = array_map(static function ($serverString) {
            return explode(':', $serverString);
        }, explode(',', $servers));

        parent::__construct($module);
    }

    protected function configure(): void
    {
        $this->bind(CacheItemPoolInterface::class)->annotatedWith(Local::class)->toConstructor(ApcuAdapter::class, ['namespace' => CacheNamespace::class])->in(Scope::SINGLETON);
        $this->bind(CacheItemPoolInterface::class)->annotatedWith(Shared::class)->toConstructor(MemcachedAdapter::class, ['namespace' => CacheNamespace::class])->in(Scope::SINGLETON);
        $this->bind()->annotatedWith(MemcacheConfig::class)->toInstance($this->servers);
        $this->bind(Memcached::class)->toProvider(MemcachedProvider::class);
    }
}
