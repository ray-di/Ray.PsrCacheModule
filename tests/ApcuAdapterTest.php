<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use PHPUnit\Framework\TestCase;

use function serialize;
use function unserialize;

class ApcuAdapterTest extends TestCase
{
    public function testSerialize(): void
    {
        $string = serialize(new ApcuAdapter());
        $this->assertNotEmpty($string);

        $this->assertInstanceOf(ApcuAdapter::class, unserialize($string));
    }
}
