<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;

use function serialize;
use function unserialize;

class ApcuAdapterTest extends TestCase
{
    public function testSerialize(): string
    {
        $string = serialize(new ApcuAdapter());
        $this->assertStringContainsString(ApcuAdapter::class, $string);

        return $string;
    }

    #[Depends('testSerialize')]
    public function testUnserialize(string $string): void
    {
        $this->assertInstanceOf(ApcuAdapter::class, unserialize($string));
    }
}
