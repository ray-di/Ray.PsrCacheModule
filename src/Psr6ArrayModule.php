<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Psr\Cache\CacheItemPoolInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;
use Ray\PsrCacheModule\Annotation\Local;
use Ray\PsrCacheModule\Annotation\Shared;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

final class Psr6ArrayModule extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(CacheItemPoolInterface::class)->annotatedWith(Local::class)->to(ArrayAdapter::class)->in(Scope::SINGLETON);
        $this->bind(CacheItemPoolInterface::class)->annotatedWith(Shared::class)->to(ArrayAdapter::class)->in(Scope::SINGLETON);
    }
}
