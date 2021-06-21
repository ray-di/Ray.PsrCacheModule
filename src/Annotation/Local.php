<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule\Annotation;

use Attribute;

/** @Annotation */
#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_METHOD)]
final class Local
{
}
