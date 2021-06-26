<?php

declare(strict_types=1);

namespace Ray\PsrCacheModule;

use Serializable;
use Symfony\Component\Cache\Adapter\FilesystemAdapter as OriginAdapter;

use function get_object_vars;
use function serialize;
use function unserialize;

class FilesystemAdapter extends OriginAdapter implements Serializable
{
    /**
     * @inheritDoc
     */
    public function serialize()
    {
        $data = get_object_vars($this);

        return serialize($data);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        /** @var array<string, scalar|object> $data */
        $data = unserialize($data);
        foreach ($data as $name => $value) {
            $this->$name = $value;
        }
    }
}
