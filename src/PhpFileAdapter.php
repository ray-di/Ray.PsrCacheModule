<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Ray\PsrCacheModule\Annotation\CacheNamespace;
use Serializable;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter as OriginAdapter;

use function func_get_args;

/** @psalm-suppress PropertyNotSetInConstructor */
class PhpFileAdapter extends OriginAdapter implements Serializable
{
    use SerializableTrait;

    /** @CacheNamespace("namespace") */
    #[CacheNamespace('namespace')]
    public function __construct(string $namespace = '', int $defaultLifetime = 0, ?string $directory = null, bool $appendOnly = false)
    {
        $this->args = func_get_args();

        parent::__construct($namespace, $defaultLifetime, $directory, $appendOnly);
    }
}
