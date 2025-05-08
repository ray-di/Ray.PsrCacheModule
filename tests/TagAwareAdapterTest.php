<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use PHPUnit\Framework\TestCase;

use function serialize;
use function unserialize;

class TagAwareAdapterTest extends TestCase
{
    public function testSerialize(): string
    {
        $adapter = new ApcuAdapter();
        $string = serialize(new TagAwareAdapter($adapter, $adapter));
        $this->assertNotSame('', $string, 'Serialize result should not be empty');

        $unserialized = unserialize($string);
        $this->assertInstanceOf(TagAwareAdapter::class, $unserialized);

        return $string;
    }
}
