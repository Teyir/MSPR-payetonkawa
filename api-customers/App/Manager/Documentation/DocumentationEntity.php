<?php

namespace Customers\Manager\Documentation;

class DocumentationEntity
{
    private string $methodName;
    private string $slug;
    /* @var \Customers\Manager\Documentation\DocumentationTypesEntity[] */
    private array $types;
    private string $methode;
    private bool $isUsingCache;
    private int $weight;
    private string $doc;

    /**
     * @param string $methodName
     * @param string $slug
     * @param \Customers\Manager\Documentation\DocumentationTypesEntity[] $types
     * @param string $type
     * @param bool $isUsingCache
     * @param int $weight
     * @param string $doc
     */
    public function __construct(string $methodName, string $slug, array $types, string $type, bool $isUsingCache, int $weight, string $doc)
    {
        $this->methodName = $methodName;
        $this->slug = $slug;
        $this->types = $types;
        $this->methode = $type;
        $this->isUsingCache = $isUsingCache;
        $this->weight = $weight;
        $this->doc = $doc;
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return array
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * @return string
     */
    public function getMethode(): string
    {
        return $this->methode;
    }


    /**
     * @return string
     */
    public function getMethodeLowerCase(): string
    {
        return mb_strtolower($this->methode);
    }

    /**
     * @return bool
     */
    public function isUsingCache(): bool
    {
        return $this->isUsingCache;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @return string
     */
    public function getDoc(): string
    {
        return $this->doc;
    }

    /**
     * @return string
     */
    public function getDocFormatted(): string
    {
        return trim(str_replace(['@desc', '*/', '*'], ['', '', "<br>"], strstr($this->doc, "@desc")));
    }

    /**
     * @return array
     */
    public function getDocForPost(): array
    {
        $toReturn = [];

        $pattern = "#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#";

        preg_match_all($pattern, $this->doc, $matches, PREG_PATTERN_ORDER);

        foreach ($matches[0] as $item) {
            if (str_starts_with($item, "@desc")) {
                continue;
            }

            $toReturn[] = trim(str_replace('@post', '', $item));
        }

        return $toReturn;
    }

    /**
     * @return array
     */
    public function getDocForPut(): array
    {
        $toReturn = [];

        $pattern = "#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#";

        preg_match_all($pattern, $this->doc, $matches, PREG_PATTERN_ORDER);

        foreach ($matches[0] as $item) {
            if (str_starts_with($item, "@desc")) {
                continue;
            }

            $toReturn[] = trim(str_replace('@put', '', $item));
        }

        return $toReturn;
    }
}