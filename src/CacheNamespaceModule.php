<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Ray\Di\AbstractModule;
use Ray\PsrCacheModule\Annotation\CacheNamespace;

final class CacheNamespaceModule extends AbstractModule
{
    public function __construct(private readonly string $namespace, ?AbstractModule $module = null)
    {
        parent::__construct($module);
    }

    protected function configure(): void
    {
        $this->bind()->annotatedWith(CacheNamespace::class)->toInstance($this->namespace);
    }
}
