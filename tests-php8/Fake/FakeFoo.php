<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Psr\Cache\CacheItemPoolInterface;
use Ray\PsrCacheModule\Annotation\Local;
use Ray\PsrCacheModule\Annotation\Shared;

class FakeFoo
{
    public function __construct(
        #[Local] public CacheItemPoolInterface $localPool,
        #[Shared] public CacheItemPoolInterface $sharedPool
    ){}
}