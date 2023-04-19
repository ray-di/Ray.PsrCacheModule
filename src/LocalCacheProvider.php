<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Ray\Di\ProviderInterface;
use Ray\PsrCacheModule\Annotation\CacheDir;
use Ray\PsrCacheModule\Annotation\CacheNamespace;
use Symfony\Component\Cache\Adapter\AbstractAdapter;

use function sys_get_temp_dir;

use const PHP_SAPI;

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
        return PHP_SAPI !== 'cli' && ApcuAdapter::isSupported() ?
            // @codeCoverageIgnoreStart
            new ApcuAdapter($this->namespace) :
            // @codeCoverageIgnoreEnd
            new FilesystemAdapter($this->namespace, 0, $this->cacheDir);
    }
}
