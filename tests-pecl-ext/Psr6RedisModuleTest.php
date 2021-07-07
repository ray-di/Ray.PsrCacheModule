<?php

declare(strict_types=1);

namespace BEAR\QueryRepository;

use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use Ray\Di\Injector;
use Ray\PsrCacheModule\Annotation\Shared;
use Ray\PsrCacheModule\CacheNamespaceModule;
use Ray\PsrCacheModule\Psr6RedisModule;

class Psr6RedisModuleTest extends TestCase
{
    public function testRedisCacheModule(): void
    {
        $module = new CacheNamespaceModule('1', new Psr6RedisModule('localhost:6379:1'));
        $cache = (new Injector($module))->getInstance(CacheItemPoolInterface::class, Shared::class);
        $this->assertInstanceOf(CacheItemPoolInterface::class, $cache);
    }
}
