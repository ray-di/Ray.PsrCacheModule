<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Serializable;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter as OriginAdapter;

use function func_get_args;

class PhpFileAdapter extends OriginAdapter implements Serializable
{
    use SerializableTrait;

    public function __construct(string $namespace = '', int $defaultLifetime = 0, ?string $directory = null, bool $appendOnly = false)
    {
        $this->args = func_get_args();
        parent::__construct($namespace, $defaultLifetime, $directory, $appendOnly);
    }
}
