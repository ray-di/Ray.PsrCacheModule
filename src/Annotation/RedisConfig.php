<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule\Annotation;

use Attribute;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;
use Ray\Di\Di\Qualifier;

/**
 * @Annotation
 * @Qualifier
 * @NamedArgumentConstructor
 */
#[Attribute]
#[Qualifier]
final class RedisConfig
{
    public function __construct(public string $value = '')
    {
    }
}
