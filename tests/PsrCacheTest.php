<?php

declare(strict_types=1);

namespace BEAR\PsrCache;

use BEAR\AppMeta\AbstractAppMeta;
use BEAR\PsrCache\Annotation\Shared;
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
        $meta = new class ('a') extends AbstractAppMeta {
            public function __construct(string $name)
            {
                $this->name = $name;
            }
        };
        $module = new NamedCacheModule($meta, new ApcuCacheModule());
        $cache = (new Injector($module))->getInstance(CacheItemPoolInterface::class);
        $this->assertInstanceOf(CacheItemPoolInterface::class, $cache);
    }

    public function testRedisCacheModule(): void
    {
        $meta = new class ('a') extends AbstractAppMeta {
            public function __construct(string $name)
            {
                $this->name = $name;
            }
        };
        $module = new NamedCacheModule($meta, new RedisCacheModule(['localhost', 6379]));
        $cache = (new Injector($module))->getInstance(CacheItemPoolInterface::class, Shared::class);
        $this->assertInstanceOf(CacheItemPoolInterface::class, $cache);
    }
}
