<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ApcuAdapter;

use function serialize;
use function unserialize;

class ApcuAdapterTest extends TestCase
{
    public function testSerialize(): string
    {
        $string = serialize(new ApcuAdapter());
        $this->assertIsString($string);

        return $string;
    }

    /**
     * @depends testSerialize
     */
    public function testUnserialize(string $string): void
    {
        $this->assertInstanceOf(ApcuAdapter::class, unserialize($string));
    }
}
