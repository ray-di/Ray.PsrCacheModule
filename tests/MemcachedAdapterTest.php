<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use PHPUnit\Framework\TestCase;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Symfony\Component\Cache\Adapter\AbstractAdapter;

use function serialize;
use function unserialize;

class MemcachedAdapterTest extends TestCase
{
    public function testSerialize(): string
    {
        $string = serialize(new MemcachdAdapter(new MemcachedProvider([['127.0.0.1', '11211']])));
        $this->assertIsString($string);

        return $string;
    }

    /** @depends testSerialize */
    public function testUnserialize(string $string): void
    {
        $this->assertInstanceOf(MemcachdAdapter::class, unserialize($string));
    }

    public function testCacheNamespaceModule(): void
    {
        $injector = new Injector(new class extends AbstractModule{
            protected function configure(): void
            {
                $this->install(new CacheNamespaceModule('a'));
                $this->install(new CacheDirModule('/tmp/a'));
                $this->bind(AbstractAdapter::class)->to(MemcachdAdapter::class);
                $this->install(new Psr6MemcachedModule('127.0.0.1:6379:1'));
            }
        });
        $adapter = $injector->getInstance(AbstractAdapter::class);
        $this->assertInstanceOf(MemcachdAdapter::class, $adapter);
    }
}
