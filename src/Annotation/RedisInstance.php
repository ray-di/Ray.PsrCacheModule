<?php

declare(strict_types=1);

namespace BEAR\PsrCache\Annotation;

use Attribute;
use Ray\Di\Di\Qualifier;

/**
 * @Annotation
 * @Qualifier()
 */
#[Attribute, Qualifier]
final class RedisInstance
{
}
