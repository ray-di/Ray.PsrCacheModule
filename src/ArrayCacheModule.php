<?php

declare(strict_types=1);

namespace BEAR\PsrCache;

use BEAR\PsrCache\Annotation\Shared;
use Psr\Cache\CacheItemPoolInterface;
use Ray\Di\AbstractModule;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

final class ArrayCacheModule extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(CacheItemPoolInterface::class)->to(ArrayAdapter::class);
        $this->bind(CacheItemPoolInterface::class)->annotatedWith(Shared::class)->to(ArrayAdapter::class);
    }
}
