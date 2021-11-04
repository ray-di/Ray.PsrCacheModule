<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Serializable;
use Symfony\Component\Cache\Adapter\FilesystemAdapter as OriginAdapter;
use Symfony\Component\Cache\Marshaller\MarshallerInterface;

use function func_get_args;

class FilesystemAdapter extends OriginAdapter implements Serializable
{
    use SerializableTrait;

    public function __construct(string $namespace = '', int $defaultLifetime = 0, ?string $directory = null, ?MarshallerInterface $marshaller = null)
    {
        $this->args = func_get_args();
        parent::__construct($namespace, $defaultLifetime, $directory, $marshaller);
    }
}
