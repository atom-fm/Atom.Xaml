<?php

namespace Atom\Xaml\Parser;

final class Node
{
    public $name;
    public $attributes = [];
    public $nodes = [];
    public $content = "";

    public function getAttributes()
    {
        $result = [];
        foreach ($this->attributes as $key => $value) {
            $key[0] = strtolower($key[0]);
            $result[$key] = trim($value, "\"");
        }
        return $result;
    }

    public function getTextContent(): string
    {
        return $this->content;
    }

    public function getChildNodes(): array
    {
        return $this->nodes;
    }

    public function getNamespace(): string
    {
        return "";
    }
    public function getComponentName(): string
    {
        return "";
    }
    public function getPropertyName(): string
    {
        return "";
    }
}
