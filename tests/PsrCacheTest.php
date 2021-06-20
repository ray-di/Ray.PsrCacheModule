<?php

declare(strict_types=1);

namespace BEAR\PsrCache;

use PHPUnit\Framework\TestCase;

class PsrCacheTest extends TestCase
{
    /** @var PsrCache */
    protected $psrCache;

    protected function setUp(): void
    {
        $this->psrCache = new PsrCache();
    }

    public function testIsInstanceOfPsrCache(): void
    {
        $actual = $this->psrCache;
        $this->assertInstanceOf(PsrCache::class, $actual);
    }
}
