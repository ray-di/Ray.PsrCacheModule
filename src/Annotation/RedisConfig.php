<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule\Annotation;

use Attribute;
use Ray\Di\Di\Qualifier;

#[Attribute]
#[Qualifier]
final class RedisConfig
{
    public function __construct(public string $value = '')
    {
    }
}
