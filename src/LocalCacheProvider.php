<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Ray\Di\ProviderInterface;
use Ray\PsrCacheModule\Annotation\CacheNamespace;

/**
 * @implements ProviderInterface<ApcuAdapter>
 */
final class LocalCacheProvider implements ProviderInterface
{
    /** @var string */
    private $namespace;

    #[CacheNamespace('namespace')]
    public function __construct(string $namespace = '')
    {
        $this->namespace = $namespace;
    }

    /**
     * {@inheritdoc}
     */
    public function get(): ApcuAdapter
    {
        return new ApcuAdapter($this->namespace);
    }
}
