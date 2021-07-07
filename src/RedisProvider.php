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
    /** @var list<string> */
    private $server;

    /**
     * @param list<string> $server
     *
     * @RedisConfig("server")
     */
    #[RedisConfig('server')]
    public function __construct(array $server)
    {
        $this->server = $server;
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        $redis = new Redis();
        $host = $this->server[0];
        $port = (int) $this->server[1];
        $connected = $redis->connect($host, $port);
        if (! $connected) {
            // @codeCoverageIgnoreStart
            throw new RedisConnectionException(sprintf('%s:%s', $host, $port));
            // @codeCoverageIgnoreStart
        }

        return $redis;
    }
}
