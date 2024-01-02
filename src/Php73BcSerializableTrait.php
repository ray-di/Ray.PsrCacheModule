<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use function serialize;
use function unserialize;

trait Php73BcSerializableTrait
{
    /**
     * {@inheritDoc}
     *
     * @psalm-suppress MethodSignatureMustProvideReturnType
     */
    final public function serialize()
    {
        return serialize($this->__serialize());
    }

    /**
     * @psalm-suppress all
     *
     * {@inheritDoc}
     */
    final public function unserialize($serializedData): void // phpcs:ignore SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
    {
        $array = unserialize($serializedData);
        $this->__unserialize($array); // @phpstan-ignore-line
    }
}
