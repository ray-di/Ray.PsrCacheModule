<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use function call_user_func_array;
use function serialize;
use function unserialize;

trait SerializableTrait
{
    /** @var array<int, mixed> */
    private $args;

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return serialize($this->__serialize());
    }

    /**
     * @psalm-param string $serializedData
     *
     * @inheritDoc
     */
    public function unserialize($serializedData)
    {
        /** @var array<mixed> $array */
        $array = unserialize($serializedData);
        $this->__unserialize($array);
    }

    /**
     * @return array<mixed>
     */
    public function __serialize(): array
    {
        return $this->args;
    }

    /**
     * @param array<mixed> $data
     */
    public function __unserialize(array $data): void
    {
        call_user_func_array([$this, '__construct'], $data); // @phpstan-ignore-line
    }
}
