<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use PHPUnit\Framework\TestCase;

use function serialize;
use function unserialize;

class PhpFileAdapterTest extends TestCase
{
    public function testSerialize(): void
    {
        $string = serialize(new PhpFileAdapter());
        $this->assertNotEmpty($string);

        $this->assertInstanceOf(PhpFileAdapter::class, unserialize($string));
    }
}
