<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Ray\Di\ProviderInterface;
use Ray\PsrCacheModule\Annotation\RedisConfig;
use Ray\PsrCacheModule\Exception\RedisConnectionException;
use Redis;

use function sprintf;

/** @implements ProviderInterface<Redis> */
final class RedisProvider implements ProviderInterface
{
    /**
     * @param list<string> $server
     *
     * @RedisConfig("server")
     */
    #[RedisConfig('server')]
    public function __construct(private array $server)
    {
    }

    /** {@inheritDoc}*/
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
            throw new RedisConnectionException(sprintf('%s:%s', $host, $port)); // @codeCoverageIgnore
        }

        return $redis;
    }
}
