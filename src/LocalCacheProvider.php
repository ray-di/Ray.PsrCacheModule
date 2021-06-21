<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Ray\Di\ProviderInterface;
use Ray\PsrCacheModule\Annotation\CacheDir;
use Ray\PsrCacheModule\Annotation\CacheNamespace;
use Symfony\Component\Cache\Adapter\ApcuAdapter;
use Symfony\Component\Cache\Adapter\ChainAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

use function sys_get_temp_dir;

class LocalCacheProvider implements ProviderInterface
{
    /** @var string */
    private $cacheDir;

    /** @var string */
    private $namespace;

    #[CacheDir('cacheDir')]
    #[CacheNamespace('namespace')]
    public function __construct(string $cacheDir = '', string $namespace = '')
    {
        $this->cacheDir = $cacheDir ? $cacheDir :  sys_get_temp_dir();
        $this->namespace = $namespace;
    }

    /**
     * {@inheritdoc}
     */
    public function get(): ChainAdapter
    {
        return new ChainAdapter([
            new ApcuAdapter($this->namespace),
            new FilesystemAdapter($this->namespace, 0, $this->cacheDir),
        ]);
    }
}
