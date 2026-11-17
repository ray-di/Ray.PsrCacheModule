<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule\Annotation;

use Attribute;
use Ray\Di\Di\Qualifier;

/**
 * Qualifies the shared cache, whose scope is set by the installed module
 * (Psr6RedisModule and Psr6MemcachedModule share it among the web servers)
 */
#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_METHOD)]
#[Qualifier]
final class Shared
{
    public function __construct(public string $value = '')
    {
    }
}
