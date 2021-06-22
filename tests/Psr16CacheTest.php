<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\PsrCacheModule\Annotation\Local;

class Psr16CacheTest extends TestCase
{
    public function testPsr16CacheModule(): void
    {
        $module = new Psr16CacheModule(new ArrayCacheModule());
        $this->assertInstanceOf(AbstractModule::class, $module);
        $cache = (new Injector($module))->getInstance(CacheInterface::class, Local::class);
        $this->assertInstanceOf(CacheInterface::class, $cache);
    }
}
