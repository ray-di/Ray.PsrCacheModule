<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule\Annotation;

use Attribute;
use Ray\Di\Di\Qualifier;

/**
 * Qualifies the cache that each web server keeps to itself
 */
#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_METHOD)]
#[Qualifier]
final class Local
{
    public function __construct(public string $value = '')
    {
    }
}
