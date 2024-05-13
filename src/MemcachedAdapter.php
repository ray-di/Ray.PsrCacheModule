<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Serializable;
use Symfony\Component\Cache\Adapter\MemcachedAdapter as OriginAdapter;
use Symfony\Component\Cache\Marshaller\MarshallerInterface;

use function func_get_args;

/** @psalm-suppress PropertyNotSetInConstructor */
class MemcachedAdapter extends OriginAdapter implements Serializable
{
    use SerializableTrait;

    public function __construct(MemcachedProvider $provider, string $namespace = '', int $defaultLifetime = 0, ?MarshallerInterface $marshaller = null)
    {
        $this->args = func_get_args();

        parent::__construct($provider->get(), $namespace, $defaultLifetime, $marshaller);
    }
}
