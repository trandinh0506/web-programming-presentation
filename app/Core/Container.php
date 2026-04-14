<?php

namespace App\Core;

class Container
{
    private array $bindings = [];

    public function set(string $key, callable $resolver): void
    {
        $this->bindings[$key] = $resolver;
    }

    public function get(string $key)
    {
        if (!isset($this->bindings[$key])) {
            throw new \Exception("No binding found for {$key}");
        }

        return $this->bindings[$key]($this);
    }
}
