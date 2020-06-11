<?php

namespace Atom\Xaml;

use Atom\Xaml\Controls\Control;
use Atom\Xaml\Interfaces\IComponentProvider;
use RuntimeException;

class ComponentProvider implements IComponentProvider
{
    private $directories = [];
    private $namespaces = [];
    private $cache = [];

    public function findComponent(string $name)
    {
        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        foreach ($this->directories as $directory) {
            $path = $directory. "/" . $name . ".php";
            if (is_file($path)) {
                $this->cache[$name] = $result = [1, $path];
                return $result;
            }
        }
        foreach ($this->namespaces as $namespace) {
            $className = $namespace . "\\" . $name;
            if (class_exists($className)) {
                $this->cache[$name] = $result = [2, $className];
                return $result;
            }
        }
        return false;
    }

    public function hasComponent(string $name): bool
    {
        return $this->findComponent($name) !== false;
    }

    public function createComponent(string $name): ?object
    {
        $location = $this->findComponent($name);
        if (is_array($location)) {
            [$type, $component] = $location;
            if ($type == 1) {
                return new Control($component);
            } else {
                return new $component();
            }
        }
        throw new RuntimeException("Component $name can't be found.");
    }

    public function addDirectory(string $path): void
    {
        $this->directories[] = $path;
    }

    public function addNamespace(string $namespace): void
    {
        $this->namespaces[] = $namespace;
    }
}
