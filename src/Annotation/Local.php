<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule\Annotation;

use Attribute;
use Ray\Di\Di\Qualifier;

/**
 * @Annotation
 * @Qualifier
 */
#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_METHOD), Qualifier]
final class Local
{
}
