<?php

declare(strict_types=1);

namespace BEAR\QueryRepository;

use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use Ray\Di\Injector;
use Ray\PsrCacheModule\Annotation\Local;
use Ray\PsrCacheModule\Psr6ApcuModule;
use Ray\PsrCacheModule\CacheNamespaceModule;

class Psr6ApcuModuleTest extends TestCase
{
    public function testApcuCacheModule(): void
    {
        $module = new CacheNamespaceModule('1', new Psr6ApcuModule());
        $cache = (new Injector($module))->getInstance(CacheItemPoolInterface::class, Local::class);
        $this->assertInstanceOf(CacheItemPoolInterface::class, $cache);
    }
}
