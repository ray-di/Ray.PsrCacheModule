# Ray.PsrCacheModule

This package is the Ray.Di module that performs the PSR-6 interface binding.

You can use the PSR6 cache interface in two ways: `Local` and `Public`.
`Local` is for caches that do not need to be shared among multiple web servers, and `Public` is for caches that need to be shared.

**PHP8**
```php
use Psr\Cache\CacheItemPoolInterface;
use Ray\PsrCacheModule\Annotation\Local;
use Ray\PsrCacheModule\Annotation\Shared;

class Foo
{
    public function __construct(
        #[Local] private CacheItemPoolInterface $localPool, 
        #[Shared] private CacheItemPoolInterface $sharedPool
    ){}
}
```

**PHP7.4**

```php
use Psr\Cache\CacheItemPoolInterface;
use Ray\PsrCacheModule\Annotation\Local;
use Ray\PsrCacheModule\Annotation\Shared;

class Foo
{
    private CacheItemPoolInterface $localPool;
    private CacheItemPoolInterface $sharedPool;
    
    /**
     * @Local('localPool') 
     * @Shared('sharedPool') 
     */
    public function __construct(
        CacheItemPoolInterface $localPool, 
        CacheItemPoolInterface $sharedPool
    ){
        $this->localPool = $localPool;
        $this->sharedPool = $sharedPool;
    }
}
```

## Installation

    composer require ray/psr-cache-module

## Module install

### ArrayCacheModule

This module is for development.

* Local: Array
* Shared: Array

```php
use Ray\PsrCacheModule\ArrayCacheModule;

new ArrayCacheModule();
```

### ApcuCacheModule

This module is for a single web server.

* Local: Chain(APC, File)
* Shared: Chain(APC, File)

```php
use Ray\PsrCacheModule\ApcuCacheModule;

new ApcuCacheModule();
```

### RedisCacheModule

This module is for multiple web servers.

* Local: Chain(APC, File)
* Shared: Redis

```php
use Ray\PsrCacheModule\RedisCacheModule;

new RedisCacheModule(['localhost', '6379']);
```

## Common Configuration Module

### CacheDirModule

Specifies the cache directory. Optional.

```php
use Ray\PsrCacheModule\CacheDirModule;

new CacheDirModule('path/to/dir');
```

### CacheNamespaceModule

Specifies the cache namespace (when multiple applications are placed on a single cache server).
Optional.

```php
use Ray\PsrCacheModule\CacheNamespaceModule;

new CacheNamespaceModule('app1');
```

