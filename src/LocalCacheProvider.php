<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Ray\Di\ProviderInterface;
use Ray\PsrCacheModule\Annotation\CacheDir;
use Ray\PsrCacheModule\Annotation\CacheNamespace;
use Symfony\Component\Cache\Adapter\AbstractAdapter;

use function sys_get_temp_dir;

/**
 * Provide APCu cache adapter if available, otherwise file cache adapter
 *
 * @implements ProviderInterface<ApcuAdapter|FilesystemAdapter>
 */
final class LocalCacheProvider implements ProviderInterface
{
    /** @var string  */
    private $cacheDir;

    /** @var string  */
    private $namespace;

    #[CacheDir('cacheDir')]
    #[CacheNamespace('namespace')]
    public function __construct(string $cacheDir = '', string $namespace = '')
    {
        $this->cacheDir = $cacheDir ?: sys_get_temp_dir();
        $this->namespace = $namespace;
    }

    public function get(): AbstractAdapter
    {
        return ApcuAdapter::isSupported() ?
            new ApcuAdapter($this->namespace) :
            new FilesystemAdapter($this->namespace, 0, $this->cacheDir);
    }
}
