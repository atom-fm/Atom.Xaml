<?php

namespace Atom\Xaml\Component;

use Atom\Xaml\Interfaces\IRenderContext;
use Atom\Xaml\Interfaces\IComponentRender;

class View
{
    private $component;
    private $context;
    private $attributes = [];

    public function __construct(Component $component, IRenderContext $context)
    {
        $this->component = $component;
        $this->context = $context;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {
        $attribute = $this->attributes[$name] ?? $this->component->getAttribute($name);

        if ($attribute instanceof IComponentRender) {
            $this->attributes[$name] = $attribute = $this->context->renderComponent($attribute);
        }

        return $attribute;
    }

    public function has(string $name): bool {
        return !empty($this->__get($name));
    }
}
