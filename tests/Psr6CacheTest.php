<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use Ray\Di\Injector;
use Ray\PsrCacheModule\Annotation\CacheDir;
use Ray\PsrCacheModule\Annotation\Shared;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\NullAdapter;

class Psr6CacheTest extends TestCase
{
    public function testDevPsrCacheModule(): void
    {
        $cache = (new Injector(new Psr6NullModule()))->getInstance(CacheItemPoolInterface::class, Shared::class);
        $this->assertInstanceOf(NullAdapter::class, $cache);
    }

    public function testArrayCacheModule(): void
    {
        $cache = (new Injector(new Psr6ArrayModule()))->getInstance(CacheItemPoolInterface::class, Shared::class);
        $this->assertInstanceOf(ArrayAdapter::class, $cache);
    }

    public function testCacheDirModule(): void
    {
        $module = new CacheDirModule('/tmp');
        $cacheDir = (new Injector($module))->getInstance('', CacheDir::class);
        $this->assertSame('/tmp', $cacheDir);
    }

    public function testPsr6LocalCacheModule(): void
    {
        $module = new Psr6LocalCacheModule();
        $cache = (new Injector($module))->getInstance(CacheItemPoolInterface::class, Shared::class);
        $this->assertTrue($cache instanceof ApcuAdapter || $cache instanceof FilesystemAdapter);
    }
}
