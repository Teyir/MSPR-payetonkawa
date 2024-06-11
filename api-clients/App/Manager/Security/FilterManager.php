<?php

namespace Clients\Manager\Security;

use Clients\Manager\Version\VersionManager;

class FilterManager
{
    /**
     * @param string $url
     * @param bool $ignoreVersion
     * @return string
     * @desc Filter complete url
     */
    public static function filterUrl(string $url, bool $ignoreVersion = false): string
    {
        $formattedData = preg_replace('/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()!@:%_\+.~#?&\/\/=]*)/', '', $url);

        if ($ignoreVersion) {
            $formattedData = str_replace('v' . VersionManager::VERSION . '/', '', $formattedData);
        }

        return $formattedData;
    }

    /**
     * @param string $data
     * @param int $maxLength
     * @param int $filter
     * @return string
     * @desc Securely filter data with maxlength parameter and custom filter, see @link
     * @link https://www.php.net/manual/en/filter.filters.sanitize.php
     */
    public static function filterData(string $data, int $maxLength = 128, int $filter = FILTER_UNSAFE_RAW): string
    {
        $data = trim(preg_replace("/<\?.*\?>/", '', $data)); //Remove scripts tags
        $data = mb_substr($data, 0, $maxLength);
        return filter_var($data, $filter);
    }

    /**
     * @param string $data
     * @param int $maxLength
     * @return string
     * @desc Securely filter data with maxlength parameter => optimized for strings
     */
    public static function filterInputStringPost(string $data, int $maxLength = 255): string
    {
        return mb_substr(trim(htmlspecialchars(filter_input(INPUT_POST, $data))), 0, $maxLength);
    }

    /**
     * @param string $data
     * @param int $maxLength
     * @return int
     * @desc Securely filter data with maxlength parameter => optimized for strings
     */
    public static function filterInputIntPost(string $data, int $maxLength = 128): int
    {
        return (int)mb_substr(trim(filter_input(INPUT_POST, $data, FILTER_SANITIZE_NUMBER_INT)), 0, $maxLength);
    }

    /**
     * @param string $data
     * @param int $maxLength
     * @return boolean
     * @desc Securely filter data with maxlength parameter => optimized for strings
     */
    public static function filterInputBoolPost(string $data, int $maxLength = 128): bool
    {
        return (bool)mb_substr(trim(filter_input(INPUT_POST, $data, FILTER_VALIDATE_BOOLEAN)), 0, $maxLength);
    }

    /**
     * @param string $data
     * @param int $maxLength
     * @return string
     * @desc Securely filter data with maxlength parameter => optimized for strings
     */
    public static function filterInputStringGet(string $data, int $maxLength = 128): string
    {
        return mb_substr(trim(filter_input(INPUT_GET, $data, FILTER_SANITIZE_FULL_SPECIAL_CHARS)), 0, $maxLength);
    }

    /**
     * @param string $data
     * @param int $maxLength
     * @return int
     * @desc Securely filter data with maxlength parameter => optimized for strings
     */
    public static function filterInputIntGet(string $data, int $maxLength = 128): int
    {
        return mb_substr(trim(filter_input(INPUT_GET, $data, FILTER_SANITIZE_NUMBER_INT)), 0, $maxLength);
    }

    /**
     * @param string $data
     * @param int $maxLength
     * @return boolean
     * @desc Securely filter data with maxlength parameter => optimized for strings
     */
    public static function filterInputBoolGet(string $data, int $maxLength = 128): bool
    {
        return (bool)mb_substr(trim(filter_input(INPUT_GET, $data, FILTER_VALIDATE_BOOLEAN)), 0, $maxLength);
    }

    /**
     * @param string $mail
     * @return bool
     * @desc We are checking if this string is an email address. <b>Please filter before use</b>
     */
    public static function isEmail(string $mail): bool
    {
        return filter_var($mail, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param string $data
     * @return string
     * @desc Prepare string for sql. Fix #039 for apostrophe.
     */
    public static function prepareSqlInsert(string $data): string
    {
        return html_entity_decode(trim($data), ENT_QUOTES, 'UTF-8');
    }
}