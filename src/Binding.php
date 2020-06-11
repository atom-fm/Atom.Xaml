<?php

namespace Atom\Xaml;

use ReflectionClass;
use Atom\Xaml\Component\Component;

final class Binding
{
    private $expression;
    private $component;
    private $xamlContext;

    public function __construct(Component $component, string $expression)
    {
        $this->component = $component;
        $this->expression = $expression;
    }

    public function getValue()
    {
        $parts = explode(".", $this->expression);
        $size = count($parts);
        $context = $this->component->getDataContext();

        for ($i = 0; $i < $size; $i++) {
            if (empty($context)) {
                return null;
            }
            $context = $this->getProperty($context, $parts[$i]);
        }
        return $context;
    }

    public function getProperty($instance, string $property)
    {
        if (is_array($instance)) {
            return $instance[$property] ?? null;
        }
        $getter = "get{$property}";
        $reflection = new ReflectionClass($instance);
        if ($reflection->hasMethod($getter)) {
            return $reflection->getMethod($getter)->invoke($instance);
        }
        if ($reflection->hasProperty($property)) {
            return $reflection->getProperty($property)->getValue($instance);
        }
        return null;
    }
}

class BindingCollection
{
    public $items = [];
}
