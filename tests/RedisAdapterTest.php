<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use PHPUnit\Framework\TestCase;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Redis;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Contracts\Cache\ItemInterface;

use function assert;
use function serialize;
use function unserialize;

class RedisAdapterTest extends TestCase
{
    /** @return array{0:string, 1: RedisAdapter} */
    public function testSerialize(): array
    {
        $client = RedisAdapter::createConnection(
            'redis://localhost',
        );
        assert($client instanceof Redis);
        $adapter = new RedisAdapter($client);
        $adapter->get('foo', static function (ItemInterface $item) {
            return 'foobar';
        });
        $foo = $adapter->get('foo', static function (ItemInterface $item) {
            return '_no_serve_';
        });
        $this->assertSame('foobar', $foo);
        $string = serialize($adapter);
        $this->assertIsString($string);

        return [$string, $adapter];
    }

    /**
     * @param array{0:string, 1: RedisAdapter} $adapters
     *
     * @depends testSerialize
     */
    public function testUnserialize(array $adapters): void
    {
        $this->assertInstanceOf(RedisAdapter::class, $adapters[1]);
        $this->assertSame('foobar', $adapters[1]->get('foo', static function (ItemInterface $item) {
            return '_no_serve_in_object';
        }));

        $adapter0 = unserialize($adapters[0]);
        $this->assertInstanceOf(RedisAdapter::class, $adapter0);
        $this->assertSame('foobar', $adapter0->get('foo', static function (ItemInterface $item) {
            return '_no_serve_in_serialize';
        }));
    }

    public function testCacheNamespaceModule(): void
    {
        $injector = new Injector(new class extends AbstractModule{
            protected function configure(): void
            {
                $this->install(new CacheNamespaceModule('a'));
                $this->install(new CacheDirModule('/tmp/a'));
                $this->bind(AbstractAdapter::class)->to(RedisAdapter::class);
                $this->bind(Redis::class);
                $this->install(new Psr6RedisModule('127.0.0.1:6379:1'));
            }
        });
        $adapter = $injector->getInstance(AbstractAdapter::class);
        $this->assertInstanceOf(RedisAdapter::class, $adapter);
    }
}
