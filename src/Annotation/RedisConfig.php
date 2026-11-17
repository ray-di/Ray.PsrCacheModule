<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule\Annotation;

use Attribute;
use Ray\Di\Di\Qualifier;

/**
 * Qualifies the Redis server as [host, port, dbIndex?], where the optional dbIndex selects the database
 */
#[Attribute]
#[Qualifier]
final class RedisConfig
{
    public function __construct(public string $value = '')
    {
    }
}
