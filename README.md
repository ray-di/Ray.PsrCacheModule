# Ray.PsrCacheModule

[![codecov](https://codecov.io/gh/ray-di/Ray.PsrCacheModule/branch/1.x/graph/badge.svg?token=9X3wbURrU9)](https://codecov.io/gh/ray-di/Ray.PsrCacheModule)
[![Type Coverage](https://shepherd.dev/github/ray-di/Ray.PsrCacheModule/coverage.svg)](https://shepherd.dev/github/ray-di/Ray.PsrCacheModule)
[![Continuous Integration](https://github.com/ray-di/Ray.PsrCacheModule/actions/workflows/continuous-integration.yml/badge.svg)](https://github.com/ray-di/Ray.PsrCacheModule/actions/workflows/continuous-integration.yml)
[![Psalm level](https://shepherd.dev/github/ray-di/Ray.PsrCacheModule/level.svg?)](https://psalm.dev/)

This package is the Ray.Di module that performs the [PSR-6](https://www.php-fig.org/psr/psr-6/) / [PSR-16](https://www.php-fig.org/psr/psr-16/) interface binding.

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

Create object graph

```php
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\PsrCacheModule\Psr6ArrayModule;

$foo = (new Injector(new class extends AbstractModule {
    protected function configure()
    {
        $this->install(new Psr6ArrayModule()); // PSR-6 
        // $this->install(new Psr16CacheModule()); // PSR-16
    }
}))->getInstance(Foo::class);

assert($foo instanceof Foo);
````

## Installation

    composer require ray/psr-cache-module

## Module install

## PSR-6

### Psr6NullModule

This module is for the development.

* Local: Null
* Shared: Null

```php
use Ray\PsrCacheModule\Psr6NullModule;

new Psr6NullModule();
```

### Psr6ArrayModule

This module is for the development.

* Local: Array
* Shared: Array

```php
use Ray\PsrCacheModule\Psr6ArrayModule;

new Psr6ArrayModule();
```

### Psr6ApcuModule

This module is for a standalone server

* Local: Chain(APC, File)
* Shared: Chain(APC, File)

```php
use Ray\PsrCacheModule\Psr6ApcuModule;

new Psr6ApcuModule();
```

### Psr6RedisModule

This module is for multiple servers.

* Local: Chain(APC, File)
* Shared: [Redis](https://github.com/phpredis/phpredis/)

```php
use Ray\PsrCacheModule\Psr6RedisModule;

new Psr6RedisModule('redis1:6379:1'); // host:port:dbIndex
```

### Psr6MemcachedModule

This module is for multiple servers.

* Local: Chain(APC, File)
* Shared: [Memcached](https://www.php.net/manual/en/class.memcached.php)

```php
use Ray\PsrCacheModule\Psr6MemcachedModule;

new Psr6MemcachedModule('memcached1:11211:60,memcached2:11211:33');  // host:port:weight
```
See https://www.php.net/manual/en/memcached.addservers.php

## PSR-16

If you install Psr16CacheModule, the cache engine installed with Psr6*Module can be used with PSR-16 interface.
PSR-16 bindings use PSR-6 bindings.

```php
use Ray\PsrCacheModule\Psr16CacheModule;

new Psr16CacheModule();
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

