# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Ray.PsrCacheModule is a dependency injection module for Ray.Di that provides PSR-6 (Cache) and PSR-16 (Simple Cache) interface bindings. It supports multiple cache backends (Redis, Memcached, APCu, Filesystem, Array) and distinguishes between "Local" (non-shared) and "Shared" (multi-server) cache types.

## Core Architecture

### Module System

The project uses Ray.Di's module system to bind cache implementations:

- **Psr6*Module classes** (e.g., `Psr6RedisModule`, `Psr6ApcuModule`) configure dependency injection bindings
- Each module binds `CacheItemPoolInterface` with either `#[Local]` or `#[Shared]` annotations
- Modules can be chained using the optional `$module` constructor parameter

### Cache Adapter Pattern

- **Custom Adapters**: `RedisAdapter`, `MemcachedAdapter`, `ApcuAdapter`, `FilesystemAdapter` extend Symfony Cache adapters
- **Serialization**: Custom adapters use `SerializableTrait` to make Redis/Memcached connections serializable (required for DI container serialization)
- **Provider Pattern**: Complex cache setup uses providers (e.g., `ImmutableCacheProvider`, `LocalCacheProvider`, `RedisProvider`)

### Annotation System

- `#[Local]` - For caches that don't need cross-server sharing
- `#[Shared]` - For caches shared across multiple servers
- `#[CacheDir]`, `#[CacheNamespace]`, `#[RedisConfig]`, `#[MemcacheConfig]` - Configuration injection

### Directory Structure

- `src/` - Main source code
- `src-deprecated/` - Deprecated code (e.g., typo `MemcachdAdapter.php`)
- `src-files/` - Polyfill files (e.g., `apcu.php` for testing)
- `tests/` - PHPUnit tests (all PHP versions)
- `tests-php8/` - PHP 8+ specific tests
- `tests-pecl-ext/` - Tests requiring PECL extensions (Redis, Memcached)

## Essential Commands

### Testing
```bash
composer test              # Run PHPUnit tests only
composer tests             # Run coding standards, static analysis, and tests (use before PR)
composer coverage          # Generate coverage report with Xdebug
composer pcov              # Generate coverage report with PCOV (faster)
```

### Code Quality
```bash
composer cs                # Check coding standards (PSR-12)
composer cs-fix            # Fix coding standard violations (REQUIRED before commit)
composer sa                # Run static analysis (PHPStan + Psalm)
composer clean             # Clear PHPStan and Psalm caches
```

### Development
```bash
composer setup             # Initial project setup
composer build             # Full build: clean, cs, sa, pcov, metrics
composer metrics           # Generate code metrics report
```

### Running Single Tests
```bash
./vendor/bin/phpunit tests/Psr6CacheTest.php
./vendor/bin/phpunit --filter testMethodName
```

## Development Workflow

1. **Before making changes**: Understand the module you're modifying (e.g., `Psr6RedisModule` binds Redis for Shared, APCu for Local)
2. **After code changes**: Run `composer cs-fix` to fix code style
3. **Before committing**: Run `composer tests` to ensure quality gates pass
4. **For coverage**: Use `composer pcov` (faster than Xdebug)

## Important Implementation Details

### Serialization Requirements

Cache adapters (Redis, Memcached) MUST be serializable because Ray.Di can serialize the entire object graph. Use `SerializableTrait` for custom adapters that wrap non-serializable resources.

### Module Configuration Flow

1. Module binds interfaces with annotations (e.g., `CacheItemPoolInterface` with `#[Shared]`)
2. Optional configuration modules (`CacheDirModule`, `CacheNamespaceModule`) inject configuration values
3. Providers instantiate actual cache instances with injected configuration
4. Ray.Di resolves dependencies based on annotations at injection points

### Testing with PECL Extensions

Tests in `tests-pecl-ext/` require Redis/Memcached extensions installed. These tests are conditionally run based on PHP version (see `phpunit.xml.dist`).

## Code Style

- Follow PSR-12 coding standard (enforced by `composer cs`)
- Declare strict types: `declare(strict_types=1);`
- Use readonly properties where appropriate (PHP 8.1+)
- Maintain PHPStan level 9 and Psalm compliance