<?php

namespace Orders\Manager\Version;

use Orders\Manager\Class\AbstractManager;

class VersionManager extends AbstractManager
{
    public const VERSION = '1';

    /**
     * @param int|null $versionOverride
     * @return string
     */
    public function getVersionSlug(?int $versionOverride = null): string
    {
        $version = self::VERSION;

        if (!is_null($versionOverride)) {
            $version = $versionOverride;
        }

        return "/v$version";
    }
}