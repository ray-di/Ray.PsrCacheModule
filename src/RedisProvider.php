<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Ray\Di\ProviderInterface;
use Ray\PsrCacheModule\Annotation\RedisConfig;
use Ray\PsrCacheModule\Exception\RedisConnectionException;
use Redis;

use function sprintf;

/** @implements ProviderInterface<Redis> */
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
    public function get(): Redis
    {
        $redis = new Redis();
        $host = $this->server[0];
        $port = (int) $this->server[1];
        $connected = $redis->connect($host, $port);
        if (isset($this->server[2])) {
            $dbIndex = (int) $this->server[2];
            $redis->select($dbIndex);
        }

        if (! $connected) {
            // @codeCoverageIgnoreStart
            throw new RedisConnectionException(sprintf('%s:%s', $host, $port));
            // @codeCoverageIgnoreStart
        }

        return $redis;
    }
}
