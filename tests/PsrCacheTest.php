<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Ray\PsrCacheModule\Annotation\Shared;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;

class PsrCacheTest extends TestCase
{
    public function testDevPsrCacheModule(): void
    {
        $module = new ArrayCacheModule();
        $this->assertInstanceOf(AbstractModule::class, $module);
    }

    public function testApcuCacheModule(): void
    {
        $module = new CacheNamespaceModule('1', new ApcuCacheModule());
        $cache = (new Injector($module))->getInstance(CacheItemPoolInterface::class);
        $this->assertInstanceOf(CacheItemPoolInterface::class, $cache);
    }

    public function testRedisCacheModule(): void
    {
        $module = new CacheNamespaceModule('1', new RedisCacheModule(['localhost', 6379]));
        $cache = (new Injector($module))->getInstance(CacheItemPoolInterface::class, Shared::class);
        $this->assertInstanceOf(CacheItemPoolInterface::class, $cache);
    }
}
