<?php

namespace Customers\Manager\Router;

use Closure;

class Route
{

    private string $path;
    private string $name;
    private bool $isUsingCache;
    private int $weight;
    private Closure $callable;
    private array $matches = [];
    private array $params = [];

    public function __construct(string $path, Closure $callable, bool $isUsingCache, int $weight = 1, string $name = "")
    {
        $this->path = trim($path, '/');
        $this->weight = $weight;
        $this->callable = $callable;
        $this->name = $name;
        $this->isUsingCache = $isUsingCache;
    }

    public function __debugInfo(): ?array
    {
        return [
            "path" => $this->path,
            "name" => $this->name,
            "weight" => $this->weight,
            "matches" => $this->matches,
            "params" => $this->params,
            "isUsingCache" => $this->isUsingCache,
        ];
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    public function &getParams(): array
    {
        return $this->params;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function isUsingCache(): bool
    {
        return $this->isUsingCache;
    }

    public function with(string $param, string $regex): Route
    {
        $this->getParams()[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }


    public function match(string $url): bool
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:(\w+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";

        if (!preg_match($regex, $url, $matches)) {
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    private function paramMatch(array $match): string
    {
        if (isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    public function call(): mixed
    {
        return call_user_func_array($this->callable, $this->matches);
    }

    public function getUrl(array $params = []): string
    {
        $path = $this->path;
        foreach ($params as $k => $v) {
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }
}