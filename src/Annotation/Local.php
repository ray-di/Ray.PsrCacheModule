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
#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_METHOD), Qualifier]
final class Local
{
    /** @var string */
    public $value;

    public function __construct(string $value = 'cache')
    {
        $this->value = $value;
    }
}
