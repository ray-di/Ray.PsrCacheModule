<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Ray\Di\AbstractModule;
use Ray\PsrCacheModule\Annotation\CacheDir;

final class CacheDirModule extends AbstractModule
{
    /** @var string */
    private $cacheDir;

    public function __construct(string $cacheDir, ?AbstractModule $module = null)
    {
        $this->cacheDir = $cacheDir;

        parent::__construct($module);
    }

    protected function configure(): void
    {
        $this->bind()->annotatedWith(CacheDir::class)->toInstance($this->cacheDir);
    }
}
