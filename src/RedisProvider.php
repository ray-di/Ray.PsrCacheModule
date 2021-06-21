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
    /** @var string */
    private $host;

    /** @var int */
    private $port;

    /**
     * @param array{0: string, 1: string} $server
     *
     * @RedisConfig("server")
     */
    #[RedisConfig('server')]
    public function __construct(array $server)
    {
        $this->host = $server[0];
        $this->port = (int) $server[1];
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        $redis = new Redis();
        $connected = $redis->connect($this->host, $this->port);
        if (! $connected) {
            // @codeCoverageIgnoreStart
            throw new RedisConnectionException(sprintf('%s/%s', $this->host, $this->port));
            // @codeCoverageIgnoreStart
        }

        return $redis;
    }
}
