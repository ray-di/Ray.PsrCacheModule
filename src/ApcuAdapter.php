<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Symfony\Component\Cache\Adapter\ApcuAdapter as OriginAdapter;
use Symfony\Component\Cache\Marshaller\MarshallerInterface;

use function func_get_args;

/**
 * @psalm-api
 * @psalm-suppress PropertyNotSetInConstructor
 */
class ApcuAdapter extends OriginAdapter
{
    use SerializableTrait;

    public function __construct(string $namespace = '', int $defaultLifetime = 0, string|null $directory = null, MarshallerInterface|null $marshaller = null)
    {
        $this->args = func_get_args();

        parent::__construct($namespace, $defaultLifetime, $directory, $marshaller);
    }
}
