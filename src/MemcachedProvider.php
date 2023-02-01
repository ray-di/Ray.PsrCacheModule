<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Memcached;
use Ray\Di\ProviderInterface;
use Ray\PsrCacheModule\Annotation\MemcacheConfig;

/** @implements ProviderInterface<Memcached> */
class MemcachedProvider implements ProviderInterface
{
    /**
     * memcached server list
     *
     * @var array<array<string>>
     */
    private $servers;

    /**
     * @param array<array<string>> $servers
     *
     * @MemcacheConfig("servers")
     * @see https://www.php.net/manual/en/memcached.addservers.php
     */
    #[MemcacheConfig('servers')]
    public function __construct(array $servers)
    {
        $this->servers = $servers;
    }

    /**
     * {@inheritdoc}
     */
    public function get(): Memcached
    {
        $memcache = new Memcached();
        $memcache->addServers($this->servers);

        return $memcache;
    }
}
