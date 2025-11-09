# Migrating from Doctrine Annotations to PHP 8 Attributes

## Overview

Ray.PsrCacheModule v1.5+ has removed the dependency on `doctrine/annotations` and now exclusively uses native PHP 8 attributes. This guide will help you migrate your application code from Doctrine annotations to PHP 8 attributes.

## Why Migrate?

- **doctrine/annotations is Abandoned**: The `doctrine/annotations` package has been officially abandoned by its maintainers. Continuing to use it poses security and compatibility risks as it will no longer receive updates or security patches.
- **Native PHP Support**: PHP 8 attributes are a built-in language feature, providing first-class support without external dependencies
- **Better Performance**: No runtime annotation parsing overhead - attributes are compiled and cached by PHP itself
- **Modern Syntax**: Cleaner, more readable code that follows PHP 8+ best practices
- **No Extra Dependencies**: Eliminates the need for the abandoned doctrine/annotations package
- **Future-Proof**: Attributes are the official PHP standard for metadata, ensuring long-term compatibility

## Migration Steps

### Step 1: Install Rector (if not already installed)

Rector is an automated refactoring tool that can convert annotations to attributes:

```bash
composer require --dev rector/rector
```

### Step 2: Run Automated Migration

Ray.PsrCacheModule provides a Rector configuration file for automated migration:

```bash
# Dry-run to preview changes
vendor/bin/rector process src --config=vendor/ray/psr-cache-module/rector-migrate.php --dry-run

# Apply the changes
vendor/bin/rector process src --config=vendor/ray/psr-cache-module/rector-migrate.php
```

If you have tests that use annotations:

```bash
vendor/bin/rector process tests --config=vendor/ray/psr-cache-module/rector-migrate.php
```

### Step 3: Manual Review

Review the changes made by Rector and adjust if necessary. Pay special attention to:

- Multi-line annotations with complex values
- Annotations with custom parameters
- Import statements (Rector should handle these automatically)

### Step 4: Remove doctrine/annotations

After migration, you can safely remove the doctrine/annotations dependency:

```bash
composer remove doctrine/annotations
```

## Before and After Examples

### Cache Directory Configuration

**Before (Doctrine Annotation):**
```php
use Ray\PsrCacheModule\Annotation\CacheDir;

class FooModule extends AbstractModule
{
    protected function configure()
    {
        /**
         * @CacheDir("cacheDir")
         */
        $this->bind()->annotatedWith('cacheDir')->toInstance('/path/to/cache');
    }
}
```

**After (PHP 8 Attribute):**
```php
use Ray\PsrCacheModule\Annotation\CacheDir;

class FooModule extends AbstractModule
{
    protected function configure()
    {
        #[CacheDir('cacheDir')]
        $this->bind()->annotatedWith('cacheDir')->toInstance('/path/to/cache');
    }
}
```

### Local Cache Injection

**Before (Doctrine Annotation):**
```php
use Psr\Cache\CacheItemPoolInterface;
use Ray\PsrCacheModule\Annotation\Local;

class UserService
{
    /**
     * @Local
     */
    public function __construct(
        private CacheItemPoolInterface $cache
    ) {}
}
```

**After (PHP 8 Attribute):**
```php
use Psr\Cache\CacheItemPoolInterface;
use Ray\PsrCacheModule\Annotation\Local;

class UserService
{
    public function __construct(
        #[Local]
        private CacheItemPoolInterface $cache
    ) {}
}
```

### Shared Cache Injection

**Before (Doctrine Annotation):**
```php
use Psr\Cache\CacheItemPoolInterface;
use Ray\PsrCacheModule\Annotation\Shared;

class SessionService
{
    /**
     * @Shared
     */
    public function __construct(
        private CacheItemPoolInterface $cache
    ) {}
}
```

**After (PHP 8 Attribute):**
```php
use Psr\Cache\CacheItemPoolInterface;
use Ray\PsrCacheModule\Annotation\Shared;

class SessionService
{
    public function __construct(
        #[Shared]
        private CacheItemPoolInterface $cache
    ) {}
}
```

### Redis Configuration

**Before (Doctrine Annotation):**
```php
use Ray\PsrCacheModule\Annotation\RedisConfig;

/**
 * @RedisConfig(host="localhost", port=6379)
 */
class AppConfig
{
    // ...
}
```

**After (PHP 8 Attribute):**
```php
use Ray\PsrCacheModule\Annotation\RedisConfig;

#[RedisConfig(host: "localhost", port: 6379)]
class AppConfig
{
    // ...
}
```

## Supported Annotations

The following Ray.PsrCacheModule annotations are automatically converted:

- `@Local` → `#[Local]` - For non-shared cache (APCu/Filesystem)
- `@Shared` → `#[Shared]` - For shared cache (Redis/Memcached)
- `@CacheDir` → `#[CacheDir]` - Cache directory configuration
- `@CacheNamespace` → `#[CacheNamespace]` - Cache namespace configuration
- `@RedisConfig` → `#[RedisConfig]` - Redis connection configuration
- `@MemcacheConfig` → `#[MemcacheConfig]` - Memcached connection configuration

**Note**: This migration tool only handles Ray.PsrCacheModule annotations. For Ray.Di annotations (such as `@Inject`, `@Named`, etc.), please refer to the [Ray.Di migration guide](https://github.com/ray-di/Ray.Di).

## Troubleshooting

### Rector doesn't find annotations

Make sure your code is using fully qualified class names in `use` statements:

```php
// Correct
use Ray\PsrCacheModule\Annotation\Local;

// Incorrect - Rector won't recognize this
use Ray\PsrCacheModule\Annotation as Cache;
```

### Import statements not updated

Rector should automatically update import statements, but if it doesn't:

1. Manually verify `use` statements are present
2. Run your IDE's "Optimize Imports" feature
3. Use tools like PHP-CS-Fixer to clean up unused imports

### Complex annotation values

For annotations with complex array values, you may need to manually adjust the syntax:

**Before:**
```php
/**
 * @RedisConfig({"host": "localhost", "port": 6379})
 */
```

**After:**
```php
#[RedisConfig(host: "localhost", port: 6379)]
```

### Testing the migration

After migration, ensure all tests pass:

```bash
composer test
```

## Manual Migration

If you prefer not to use Rector, you can manually convert annotations:

1. Replace `/** @AnnotationName */` with `#[AnnotationName]`
2. Move attributes from docblocks to the line before the method/property/class
3. For parameter annotations, place the attribute before the parameter type
4. Ensure all necessary `use` statements are present

## Need Help?

If you encounter issues during migration:

1. Check the [Ray.PsrCacheModule documentation](https://github.com/ray-di/Ray.PsrCacheModule)
2. Review the [PHP 8 Attributes documentation](https://www.php.net/manual/en/language.attributes.php)
3. [Open an issue](https://github.com/ray-di/Ray.PsrCacheModule/issues) on GitHub

## References

- [PHP 8 Attributes RFC](https://wiki.php.net/rfc/attributes_v2)
- [Rector Documentation](https://github.com/rectorphp/rector)
- [Ray.Di Documentation](https://ray-di.github.io/manuals/1.0/en/)
