<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Ray\Di\AbstractModule;
use Ray\PsrCacheModule\Annotation\CacheNamespace;

final class CacheNamespaceModule extends AbstractModule
{
    /** @var string */
    private $namespace;

    public function __construct(string $namespace, ?AbstractModule $module = null)
    {
        $this->namespace = $namespace;

        parent::__construct($module);
    }

    protected function configure(): void
    {
        $this->bind()->annotatedWith(CacheNamespace::class)->toInstance($this->namespace);
    }
}
