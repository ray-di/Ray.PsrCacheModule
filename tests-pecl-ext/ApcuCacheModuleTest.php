<?php

declare(strict_types=1);

namespace BEAR\QueryRepository;

use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use Ray\Di\Injector;
use Ray\PsrCacheModule\Annotation\Local;
use Ray\PsrCacheModule\ApcuCacheModule;
use Ray\PsrCacheModule\CacheNamespaceModule;

class ApcuCacheModuleTest extends TestCase
{
    public function testApcuCacheModule(): void
    {
        $module = new CacheNamespaceModule('1', new ApcuCacheModule());
        $cache = (new Injector($module))->getInstance(CacheItemPoolInterface::class, Local::class);
        $this->assertInstanceOf(CacheItemPoolInterface::class, $cache);
    }
}
