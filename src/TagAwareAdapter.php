<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Serializable;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\TagAwareAdapter as OriginAdapter;

use function func_get_args;

/** @psalm-suppress PropertyNotSetInConstructor */
final class TagAwareAdapter extends OriginAdapter implements Serializable
{
    use SerializableTrait;

    public function __construct(
        AdapterInterface $itemsPool,
        AdapterInterface|null $tagsPool = null,
        float $knownTagVersionsTtl = 0.15,
    ) {
        $this->args = func_get_args();

        parent::__construct($itemsPool, $tagsPool, $knownTagVersionsTtl);
    }
}
