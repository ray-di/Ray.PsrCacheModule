<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Ray\Di\ProviderInterface;
use Ray\PsrCacheModule\Annotation\RedisConfig;
use Ray\PsrCacheModule\Exception\RedisConnectionException;
use Redis;

use function sprintf;

class RedisProvider implements ProviderInterface
{
    /** @var list<list<string>> */
    private $servers;

    /**
     * @param list<list<string>> $servers
     *
     * @RedisConfig("servers")
     */
    #[RedisConfig('servers')]
    public function __construct(array $servers)
    {
        $this->servers = $servers;
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        $redis = new Redis();
        foreach ($this->servers as $server) {
            $host = $server[0];
            $port = (int) $server[1];
            $connected = $redis->connect($host, $port);
            if (! $connected) {
                // @codeCoverageIgnoreStart
                throw new RedisConnectionException(sprintf('%s:%s', $host, $port));
                // @codeCoverageIgnoreStart
            }
        }

        return $redis;
    }
}
