<?php

namespace WEB\Manager\Theme;

use WEB\Manager\Env\EnvManager;
use WEB\Manager\Manager\AbstractManager;

class ThemeManager extends AbstractManager
{
    /**
     * @return \WEB\Manager\Theme\IThemeConfig
     */
    public function getCurrentTheme(): IThemeConfig
    {
        $currentThemeName = EnvManager::getInstance()->getValue('THEME');

        return $this->getTheme($currentThemeName ?? 'Default');
    }

    /**
     * @return string
     * @desc Return absolute theme path
     */
    public function getCurrentThemePath(): string
    {
        $theme = $this->getCurrentTheme();
        return EnvManager::getInstance()->getValue('DIR') . 'Public/Themes/' . $theme->name();
    }


    /**
     * @param string $themeName
     * @return \WEB\Manager\Theme\IThemeConfig|null
     */
    public function getTheme(string $themeName): ?IThemeConfig
    {
        $namespace = 'WEB\\Theme\\' . $themeName . '\\Theme';

        if (!class_exists($namespace)) {
            return null;
        }

        $classInstance = new $namespace();

        if (!is_subclass_of($classInstance, IThemeConfig::class)) {
            return null;
        }

        return $classInstance;
    }

    /**
     * @return IThemeConfig[]
     */
    public function getInstalledThemes(): array
    {
        $toReturn = [];
        $themesFolder = 'Public/Themes';
        $contentDirectory = array_diff(scandir("$themesFolder/"), ['..', '.']);
        foreach ($contentDirectory as $theme) {
            if (file_exists("$themesFolder/$theme/Theme.php") && !empty(file_get_contents("$themesFolder/$theme/Theme.php"))) {
                $toReturn[] = $this->getTheme($theme);
            }
        }

        return $toReturn;
    }

    /**
     * @param string $theme
     * @return bool
     */
    public function isThemeInstalled(string $theme): bool
    {
        foreach ($this->getInstalledThemes() as $installedTheme) {
            if ($theme === $installedTheme->name()) {
                return true;
            }
        }

        return false;
    }
}