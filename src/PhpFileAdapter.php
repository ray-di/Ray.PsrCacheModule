<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Serializable;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter as OriginAdapter;

use function call_user_func_array;
use function func_get_args;
use function serialize;
use function unserialize;

class PhpFileAdapter extends OriginAdapter implements Serializable
{
    /** @var array<int, mixed> */
    private $args;

    public function __construct(string $namespace = '', int $defaultLifetime = 0, ?string $directory = null, bool $appendOnly = false)
    {
        $this->args = func_get_args();
        parent::__construct($namespace, $defaultLifetime, $directory, $appendOnly);
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return serialize($this->args);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        call_user_func_array([$this, '__construct'], unserialize($data)); // @phpstan-ignore-line
    }
}
