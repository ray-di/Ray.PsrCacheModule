<?php

declare(strict_types=1);

namespace BEAR\QueryRepository;

use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use Ray\Di\Injector;
use Ray\PsrCacheModule\Annotation\Shared;
use Ray\PsrCacheModule\CacheNamespaceModule;
use Ray\PsrCacheModule\Psr6MemcachedModule;
use Symfony\Component\Cache\Adapter\MemcachedAdapter;

class Psr6MemcacheModuleTest extends TestCase
{
    public function testRedisCacheModule(): void
    {
        $module = new CacheNamespaceModule('1', new Psr6MemcachedModule('localhost:11211:33,localhost:11211:66'));
        $cache = (new Injector($module))->getInstance(CacheItemPoolInterface::class, Shared::class);
        $this->assertInstanceOf(MemcachedAdapter::class, $cache);
    }
}
