<?php

namespace Customers\Manager\Cache;

use JsonException;
use Customers\Manager\Lang\LangManager;
use Customers\Manager\Security\FilterManager;

class CacheManager
{
    private string $name;
    private int $cacheTime = 86400;

    private string $dir = "Cache/";
    private string $fileName;

    public function __construct(?string $scope, string $name)
    {
        $this->name = is_null($scope) ? $name : $scope . DIRECTORY_SEPARATOR . $name;
        $this->fileName = str_replace("\\", "/", $this->dir . $this->getFormattedName() . ".cache");
    }

    public function checkCache(): bool
    {
        return file_exists($this->fileName) && filemtime($this->fileName) > time() - $this->cacheTime;
    }

    public function getCache(): array|string
    {
        $lastModifiedTime = filemtime($this->fileName);
        $etag = 'W/"' . md5($lastModifiedTime) . '"';

        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastModifiedTime) . " GMT");
        header("Cache-Control: public, max-age=" . $this->cacheTime);
        header("Etag: $etag");

        try {
            return json_decode(file_get_contents($this->fileName), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return $e;
        }
    }

    public function storeCache(array $value): void
    {
        try {
            file_put_contents(FilterManager::filterData($this->fileName), json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));
        } catch (JsonException) {
        }
    }

    public function deleteSpecificCacheFile(): void
    {
        unlink(str_replace("\\", "/", $this->dir . $this->name . ".cache"));
    }

    /**
     * @return string
     * @desc Format cache file name
     */
    private function getFormattedName(): string
    {
        return mb_strtolower($this->name . "_" . LangManager::getLang());
    }

    /**
     * @param string $dir
     * @return void
     * @desc This method delete all cache files (recursively)
     */
    public static function deleteAllFiles(string $dir = 'Cache'): void
    {
        $files = glob("$dir/*");

        foreach ($files as $file) {
            if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === "cache") {
                unlink($file);
            } elseif (is_dir($file)) {
                self::deleteAllFiles($file);
            }
        }
    }

    public static function deleteSpecificCacheFileWithPath(string $filePath): void
    {
        unlink($filePath);
    }

    public static function deleteCacheFilesForFolder(string $folder): void
    {
        $files = glob("Cache/$folder/*");

        foreach ($files as $file) {
            if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === "cache") {
                unlink($file);
            }
        }
    }

}