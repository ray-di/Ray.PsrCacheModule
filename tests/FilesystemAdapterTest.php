<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use PHPUnit\Framework\TestCase;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Symfony\Component\Cache\Adapter\AbstractAdapter;

use function serialize;
use function unserialize;

class FilesystemAdapterTest extends TestCase
{
    public function testSerialize(): string
    {
        $string = serialize(new FilesystemAdapter());
        $this->assertIsString($string);

        return $string;
    }

    /**
     * @depends testSerialize
     */
    public function testUnserialize(string $string): void
    {
        $this->assertInstanceOf(FilesystemAdapter::class, unserialize($string));
    }

    public function testCacheNamespaceModule(): void
    {
        $injector = new Injector(new class extends AbstractModule{
            protected function configure(): void
            {
                $this->install(new CacheNamespaceModule('a'));
                $this->install(new CacheDirModule('/tmp/a'));
                $this->bind(AbstractAdapter::class)->to(FilesystemAdapter::class);
            }
        });
        $adapter = $injector->getInstance(AbstractAdapter::class);
        $this->assertInstanceOf(FilesystemAdapter::class, $adapter);
    }
}
