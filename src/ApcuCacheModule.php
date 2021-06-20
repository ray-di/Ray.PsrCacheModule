<?php

declare(strict_types=1);

namespace BEAR\PsrCache;

use BEAR\PsrCache\Annotation\CacheNameSpace;
use BEAR\PsrCache\Annotation\Shared;
use Psr\Cache\CacheItemPoolInterface;
use Ray\Di\AbstractModule;
use Symfony\Component\Cache\Adapter\ApcuAdapter;

final class ApcuCacheModule extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(CacheItemPoolInterface::class)->toConstructor(ApcuAdapter::class, [
            'namespace' => CacheNameSpace::class,
        ]);
        $this->bind(CacheItemPoolInterface::class)->annotatedWith(Shared::class)->toConstructor(ApcuAdapter::class, [
            'namespace' => CacheNameSpace::class,
        ]);
    }
}
