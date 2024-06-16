<?php

namespace WEB\Manager\Package;

class PackageMenuType
{
    private string $lang;
    private string $icon;
    private string $title;
    private ?string $url;
    /* @var \WEB\Manager\Package\PackageSubMenuType[]|null $subMenus */
    private ?array $subMenus;

    /**
     * @param string $lang
     * @param string $icon
     * @param string $title
     * @param string|null $url
     * @param \WEB\Manager\Package\PackageSubMenuType[]|null $subMenus
     */
    public function __construct(string $lang, string $icon, string $title, ?string $url, ?array $subMenus)
    {
        $this->lang = $lang;
        $this->icon = $icon;
        $this->title = $title;
        $this->url = $url;
        $this->subMenus = $subMenus;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return array|null
     */
    public function getSubMenus(): ?array
    {
        return $this->subMenus;
    }
}