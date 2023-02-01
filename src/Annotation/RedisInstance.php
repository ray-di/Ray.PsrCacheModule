<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule\Annotation;

use Attribute;
use Ray\Di\Di\Qualifier;

/**
 * @Annotation
 * @Qualifier()
 */
#[Attribute]
#[Qualifier]
final class RedisInstance
{
}
