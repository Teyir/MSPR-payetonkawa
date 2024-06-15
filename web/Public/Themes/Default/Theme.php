<?php

namespace WEB\Theme\Default;

use WEB\Manager\Theme\IThemeConfig;

class Theme implements IThemeConfig
{
    public function name(): string
    {
        return "Default";
    }

    public function version(): string
    {
        return "1.0.0";
    }
}