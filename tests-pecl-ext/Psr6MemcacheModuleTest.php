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
use function unserialize;

class Psr6MemcacheModuleTest extends TestCase
{
    public function testMemcCacheModule(): CacheItemPoolInterface
    {
        $module = new CacheNamespaceModule('1', new Psr6MemcachedModule('localhost:11211:33,localhost:11211:66'));
        $cache = (new Injector($module))->getInstance(CacheItemPoolInterface::class, Shared::class);
        $this->assertInstanceOf(MemcachedAdapter::class, $cache);

        return $cache;
    }

    /**
     * @depends testMemcCacheModule
     */
    public function testSerializable(CacheItemPoolInterface $cache): void
    {
        try {
            $serializedCache = serialize($cache);
            $this->assertIsString($serializedCache);
        } catch (\Exception $e) {
            $this->fail('Serialization of $cache failed: ' . $e->getMessage());
        }
        $this->assertInstanceOf(CacheItemPoolInterface::class, unserialize($serializedCache));
    }
}
