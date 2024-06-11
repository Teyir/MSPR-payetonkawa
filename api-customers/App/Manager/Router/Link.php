<?php

namespace Customers\Manager\Router;

use Attribute;
use JetBrains\PhpStorm\ExpectedValues;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Link
{

    /**
     * @param string $path
     * @param string $method
     * @param array $variables
     * @param string|null $scope
     * @param int $weight
     * @param string|null $name
     * @param bool $isAdminRestricted
     * @param bool $isUsingCache
     * @param int|null $version
     */
    public function __construct(private readonly string                                                     $path,
                                #[ExpectedValues(flagsFromClass: LinkTypes::class)] private readonly string $method,
                                private readonly array                                                      $variables = [],
                                private readonly ?string                                                    $scope = null,
                                private readonly int                                                        $weight = 1,
                                private ?string                                                             $name = null,
                                private readonly bool                                                       $isAdminRestricted = false,
                                private readonly bool                                                       $isUsingCache = true,
                                private readonly ?int                                                       $version = null,
    )
    {
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * @return string|null
     */
    public function getScope(): ?string
    {
        return $this->scope;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isAdminRestricted(): bool
    {
        return $this->isAdminRestricted;
    }

    /**
     * @return bool
     */
    public function isUsingCache(): bool
    {
        return $this->isUsingCache;
    }

    /**
     * @return int|null
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

}