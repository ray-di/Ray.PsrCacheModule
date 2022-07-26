<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Psr\Cache\CacheItemPoolInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;
use Ray\PsrCacheModule\Annotation\CacheNamespace;
use Ray\PsrCacheModule\Annotation\Local;
use Ray\PsrCacheModule\Annotation\Shared;

final class Psr6ApcuModule extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(CacheItemPoolInterface::class)->annotatedWith(Local::class)->toConstructor(ApcuAdapter::class, ['namespace' => CacheNamespace::class])->in(Scope::SINGLETON);
        $this->bind(CacheItemPoolInterface::class)->annotatedWith(Shared::class)->toConstructor(ApcuAdapter::class, ['namespace' => CacheNamespace::class])->in(Scope::SINGLETON);
    }
}
