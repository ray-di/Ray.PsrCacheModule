<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Ray\PsrCacheModule\Annotation\CacheNamespace;
use Ray\PsrCacheModule\Annotation\Shared;
use Psr\Cache\CacheItemPoolInterface;
use Ray\Di\AbstractModule;
use Symfony\Component\Cache\Adapter\ApcuAdapter;

final class ApcuCacheModule extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(CacheItemPoolInterface::class)->toConstructor(ApcuAdapter::class, [
            'namespace' => CacheNamespace::class,
        ]);
        $this->bind(CacheItemPoolInterface::class)->annotatedWith(Shared::class)->toConstructor(ApcuAdapter::class, [
            'namespace' => CacheNamespace::class,
        ]);
    }
}
