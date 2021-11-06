<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use JetBrains\PhpStorm\Deprecated;
use Serializable;
use Symfony\Component\Cache\Adapter\FilesystemAdapter as OriginAdapter;
use Symfony\Component\Cache\Marshaller\MarshallerInterface;

use function call_user_func_array;
use function func_get_args;

#[Deprecated]
class FilesystemAdapter extends OriginAdapter implements Serializable
{
    use Php73BcSerializableTrait;

    /** @var array<int, mixed> */
    private $args;

    public function __construct(string $namespace = '', int $defaultLifetime = 0, ?string $directory = null, ?MarshallerInterface $marshaller = null)
    {
        $this->args = func_get_args();
        parent::__construct($namespace, $defaultLifetime, $directory, $marshaller);
    }

    /**
     * @inheritDoc
     */
    public function __serialize(): array
    {
        return $this->args;
    }

    /**
     * {@inheritDoc}
     */
    public function __unserialize($data)
    {
        call_user_func_array([$this, '__construct'], $data); // @phpstan-ignore-line
    }
}
