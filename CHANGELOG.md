# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.5.0] - 2025-11-10

### Changed

- **PHP 8.2+ required** (previously 8.1+)
- Update Symfony Cache dependency to `^6.0 || ^7.2`
- Use readonly properties where applicable for immutability

### Removed

- **doctrine/annotations dependency** - All annotations now use native PHP 8 attributes exclusively (security fix for abandoned package)
- Serializable interface from cache adapters (use `__serialize`/`__unserialize` magic methods)
- Unused `Php73BcSerializableTrait` class
- Unused `RedisInstance` annotation class

### Added

- **Migration Tools**: Added `rector-migrate.php` for automated annotation-to-attribute migration
- **Migration Guide**: Added `ANNOTATION_TO_ATTRIBUTE.md` with comprehensive migration instructions
- CLAUDE.md with project architecture and development workflow documentation
- Comprehensive code coverage exclusions for deprecated code

### Note

- **Migration Required**: Applications using annotations must migrate to PHP 8 attributes
- Use provided Rector configuration for automated migration: `vendor/bin/rector process src --config=vendor/ray/psr-cache-module/rector-migrate.php`
- See `ANNOTATION_TO_ATTRIBUTE.md` for detailed migration guide

### Fixed

- CI/CD workflows updated to latest GitHub Actions versions
- Replace deprecated `set-output` with `$GITHUB_OUTPUT`
- Add `--ignore-platform-req=php` for PHP 8.5 compatibility testing
- rector-migrate.php: Remove hardcoded paths to allow users to specify their own project paths

## [1.4.0] - Previous Release

For changes in version 1.4.0 and earlier, please see the git history.
