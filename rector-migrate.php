<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php80\Rector\Class_\AnnotationToAttributeRector;
use Rector\Php80\ValueObject\AnnotationToAttribute;

/**
 * Rector configuration for migrating from Doctrine Annotations to PHP 8 Attributes
 *
 * This configuration helps users migrate their code from doctrine/annotations
 * to native PHP 8 attributes for Ray.PsrCacheModule annotations.
 *
 * Usage:
 *   vendor/bin/rector process src --config=vendor/ray/psr-cache-module/rector-migrate.php --dry-run
 *   vendor/bin/rector process src --config=vendor/ray/psr-cache-module/rector-migrate.php
 */
return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withConfiguredRule(
        AnnotationToAttributeRector::class,
        [
            // Ray.PsrCacheModule Annotations
            new AnnotationToAttribute('Ray\PsrCacheModule\Annotation\Local'),
            new AnnotationToAttribute('Ray\PsrCacheModule\Annotation\Shared'),
            new AnnotationToAttribute('Ray\PsrCacheModule\Annotation\CacheDir'),
            new AnnotationToAttribute('Ray\PsrCacheModule\Annotation\CacheNamespace'),
            new AnnotationToAttribute('Ray\PsrCacheModule\Annotation\RedisConfig'),
            new AnnotationToAttribute('Ray\PsrCacheModule\Annotation\MemcacheConfig'),
        ]
    );
