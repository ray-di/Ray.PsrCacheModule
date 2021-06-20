<?php

declare(strict_types=1);

namespace BEAR\PsrCache;

use BEAR\AppMeta\AbstractAppMeta;
use BEAR\PsrCache\Annotation\CacheNameSpace;
use Ray\Di\AbstractModule;

final class NamedCacheModule extends AbstractModule
{
    /** @var AbstractAppMeta */
    private $meta;

    public function __construct(AbstractAppMeta $meta, ?AbstractModule $module = null)
    {
        $this->meta = $meta;
        parent::__construct($module);
    }

    protected function configure(): void
    {
        $this->bind(AbstractAppMeta::class)->toInstance($this->meta);
        $this->bind()->annotatedWith(CacheNameSpace::class)->toInstance($this->meta->name);
    }
}
