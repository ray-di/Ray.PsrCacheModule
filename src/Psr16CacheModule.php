<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Psr\SimpleCache\CacheInterface;
use Ray\Di\AbstractModule;
use Ray\PsrCacheModule\Annotation\Local;
use Ray\PsrCacheModule\Annotation\Shared;
use Symfony\Component\Cache\Psr16Cache;

final class Psr16CacheModule extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(CacheInterface::class)->annotatedWith(Local::class)->toConstructor(Psr16Cache::class, ['pool' => Local::class]);
        $this->bind(CacheInterface::class)->annotatedWith(Shared::class)->toConstructor(Psr16Cache::class, ['pool' => Shared::class]);
    }
}
