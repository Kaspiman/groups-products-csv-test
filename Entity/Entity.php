<?php

class Entity
{
    private $attributes = [];

    public function get($key)
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }

        return null;
    }

    public function set($key, $value): self
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function exists($key): bool
    {
        return isset($this->attributes[$key]);
    }
}