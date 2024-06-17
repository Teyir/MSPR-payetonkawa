<?php

namespace Mails\Manager\Lang;

class LangManager
{
    public static LangTypes $defaultLang = LangTypes::FR;

    /**
     * @param string|null $lang
     * @return bool
     * @desc We are checking if the $lang exist. If we don't pass parameter, we get the URL param with {@Mails\Manager\Lang\LangManager::getLang()} method.
     */
    public static function isLangExist(?string $lang): bool
    {
        if (is_null($lang)) {
            $lang = self::getLang();
        }

        return isset(LangTypes::tryFrom($lang)->value);
    }

    /**
     * @return string
     * @desc Return url lang, check if the lang exist. If not, we are retrieving the default lang.
     */
    public static function getLang(): string
    {
        if (!isset($_GET['lang'])) {
            return self::$defaultLang->value;
        }

        $lang = mb_strtoupper(mb_substr(trim(filter_input(INPUT_GET, "lang", FILTER_SANITIZE_FULL_SPECIAL_CHARS)), 0, 5));

        if (!self::isLangExist($lang)) {
            return self::$defaultLang->value;
        }

        return $lang;
    }
}