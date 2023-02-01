<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use PHPUnit\Framework\TestCase;

use function serialize;
use function unserialize;

class PhpFileAdapterTest extends TestCase
{
    public function testSerialize(): string
    {
        $string = serialize(new PhpFileAdapter());
        $this->assertIsString($string);

        return $string;
    }

    /** @depends testSerialize */
    public function testUnserialize(string $string): void
    {
        $this->assertInstanceOf(PhpFileAdapter::class, unserialize($string));
    }
}
