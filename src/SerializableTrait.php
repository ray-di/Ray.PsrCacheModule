<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use function call_user_func_array;

trait SerializableTrait
{
    use Php73BcSerializableTrait;

    /** @var array<mixed> */
    private $args;

    /** @return array<mixed> */
    public function __serialize(): array
    {
        return $this->args;
    }

    /** @param array<mixed> $data */
    public function __unserialize(array $data): void
    {
        call_user_func_array([$this, '__construct'], $data); // @phpstan-ignore-line
    }
}
