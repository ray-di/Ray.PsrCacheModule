<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule\Annotation;

use Attribute;
use Ray\Di\Di\Qualifier;

/**
 * Qualifies the list of Memcached servers as [host, port] pairs
 */
#[Attribute(Attribute::TARGET_METHOD)]
#[Qualifier]
final class MemcacheConfig
{
    public function __construct(public string $value = '')
    {
    }
}
