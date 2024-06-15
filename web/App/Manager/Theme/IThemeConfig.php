<?php


namespace WEB\Manager\Theme;

/**
 * @desc Use this interface only for theme configuration
 */
interface IThemeConfig
{
    /**
     * @return string
     * @desc The theme name.
     */
    public function name(): string;

    /**
     * @return string
     * @desc The theme version. Please use the same as the WEB Market version.
     */
    public function version(): string;
}