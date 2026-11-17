<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule\Annotation;

use Attribute;
use Ray\Di\Di\Qualifier;

/**
 * Qualifies the namespace that separates the cache keys of an application
 */
#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_METHOD)]
#[Qualifier]
final class CacheNamespace
{
    public function __construct(public string $value = '')
    {
    }
}
