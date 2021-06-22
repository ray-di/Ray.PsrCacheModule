<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use PHPUnit\Framework\TestCase;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\PsrCacheModule\Annotation\CacheDir;

class Psr6CacheTest extends TestCase
{
    public function testDevPsrCacheModule(): void
    {
        $module = new Psr6ArrayModule();
        $this->assertInstanceOf(AbstractModule::class, $module);
    }

    public function testCacheDirModule(): void
    {
        $module = new CacheDirModule('/tmp');
        $cacheDir = (new Injector($module))->getInstance('', CacheDir::class);
        $this->assertSame('/tmp', $cacheDir);
    }
}
