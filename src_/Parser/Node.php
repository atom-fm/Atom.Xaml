<?php

namespace Atom\Xaml\Parser;

use RuntimeException;

final class Node
{
    private $name = "";
    private $namespace = "";
    private $propertyName = "";
    private $componentName = "";
    private $attributes = [];
    private $nodes = [];
    private $content = "";

    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function getAttributes(): array
    {
        $result = [];
        foreach ($this->attributes as $key => $value) {
            $key[0] = strtolower($key[0]);
            $result[$key] = trim($value, "\"");
        }

        foreach ($this->getChildNodes() as $childNode) {
            if ($childNode->isProperty()) {
                $propertyName = $childNode->getPropertyName();
                $propertyName[0] = strtolower($propertyName[0]);
                $result[$propertyName] = $childNode;
            }
        }

        return $result;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
        $parts = explode(":", $name, 2);
        $rest = $name;
        if (count($parts) == 2) {
            $this->namespace = $parts[0];
            $rest = $parts[1];
        }
        $parts = explode(".", $rest);

        if (count($parts) == 2) {
            $this->componentName = $parts[0];
            $this->propertyName = $parts[1];
        } elseif (count($parts) == 1) {
            $this->componentName = $parts[0];
        } else {
            throw new RuntimeException("Tag may contain namespace, component name and property name.");
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addNode(Node $node): void
    {
        $this->nodes[] = $node;
    }

    public function setTextContent(string $content): void
    {
        $this->content = $content;
    }

    public function getTextContent(): string
    {
        return $this->content;
    }

    public function hasChildNodes(): bool
    {
        return count($this->nodes) > 0;
    }

    /** @return Node[] */
    public function getChildNodes(): array
    {
        return $this->nodes;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function getComponentName(): string
    {
        return $this->componentName;
    }

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    public function isProperty(): bool
    {
        return $this->propertyName !== "";
    }

    public function isComponent(): bool
    {
        return $this->propertyName === "";
    }
}
