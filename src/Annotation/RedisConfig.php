<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule\Annotation;

use Attribute;
use Ray\Di\Di\Qualifier;

/**
 * Qualifies the Redis server as a [host, port] pair
 */
#[Attribute]
#[Qualifier]
final class RedisConfig
{
    public function __construct(public string $value = '')
    {
    }
}
