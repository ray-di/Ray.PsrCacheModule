<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use PHPUnit\Framework\TestCase;

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
}
