<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Ray\PsrCacheModule\Annotation\RedisConfig;
use Ray\PsrCacheModule\Exception\RedisConnectionException;
use Ray\Di\ProviderInterface;
use Redis;
use RedisException;

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
        try {
            $redis->connect($this->host, $this->port);
            // @codeCoverageIgnoreStart
        } catch (RedisException $e) {
            throw new RedisConnectionException(sprintf('%s/%s', $this->host, $this->port), 0, $e);
            // @codeCoverageIgnoreStart
        }

        return $redis;
    }
}
