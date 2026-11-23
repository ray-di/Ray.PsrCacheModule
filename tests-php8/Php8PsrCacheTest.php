<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use PHPUnit\Framework\TestCase;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;

class Php8PsrCacheTest extends TestCase
{
    public function testConstructorPropertyPromotion(): void
    {
        $module = new class extends AbstractModule {
            protected function configure(): void
            {
                $this->install(new CacheNamespaceModule('1', new Psr6RedisModule('localhost:6379,localhost:6379')));
                $this->bind(FakeFoo::class);
            }
        };
        $foo = (new Injector($module))->getInstance(FakeFoo::class);
        $this->assertInstanceOf(FakeFoo::class, $foo);
    }
}
