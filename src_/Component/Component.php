<?php

namespace Atom\Xaml\Component;

use Atom\Xaml\Interfaces\IRenderContext;
use Atom\Xaml\Interfaces\IComponentParent;
use Atom\Xaml\Interfaces\IComponentRender;
use Atom\Xaml\Interfaces\IComponentContent;
use Atom\Xaml\Interfaces\IComponentContainer;
use Atom\Xaml\Interfaces\IComponentAttributes;
use Atom\Xaml\Interfaces\IDataContext;
use ReflectionClass;

class Component implements IComponentContent, IComponentContainer, IComponentAttributes, IComponentRender, IComponentParent, IDataContext
{
    private $parent = null;
    private $attributes = [];
    private $components = [];
    private $textContent = "";
    private $dataContext = null;

    public function setDataContext($context): void
    {
        $this->dataContext = $context;
    }

    public function getDataContext()
    {
        if ($this->dataContext == null) {
            $parent = $this->getParent();
            if ($parent && $parent instanceof IDataContext) {
                return $parent->getDataContext();
            }
        }
        return $this->dataContext;
    }

    public function getComponents(): array
    {
        return $this->components;
    }

    public function getParent(): ?object
    {
        return $this->parent;
    }

    public function setParent(object $component): void
    {
        $this->parent = $component;
    }

    public function setAttributes(array $attributes): void
    {
        foreach ($attributes as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    private function getBindingValue($expression)
    {
        $property = substr($expression, 1);
        $model = $this->getDataContext();
        if ($model) {
            $reflection = new ReflectionClass($model);
            if ($reflection->hasProperty($property)) {
                return $reflection->getProperty($property)->getValue($model);
            }
        }
        return $expression;
    }

    public function getAttribute(string $name, $default = null)
    {
        $value = $this->attributes[$name] ?? null;
        if (is_string($value) && $value !== "" && $value[0] == "$") {
            $value = $this->getBindingValue($value);
        }
        return $value ?? $default;
    }

    public function addComponent(object $component): void
    {
        $this->components[] = $component;
        if ($component instanceof IComponentParent) {
            $component->setParent($this);
        }
    }

    public function setTextContent(string $content): void
    {
        $this->textContent = $content;
    }

    public function getTextContent(): string
    {
        $value =  $this->textContent;
        return (string)$this->getBindingValue($value);
    }

    public function hasRenderableComponents(): bool
    {
        foreach ($this->components as $component) {
            if ($component instanceof IComponentRender) {
                return true;
            }
        }
        return false;
    }

    public function renderComponents(IRenderContext $context): void
    {
        foreach ($this->components as $component) {
            if ($component instanceof IComponentRender) {
                $component->render($context);
            }
        }
    }

    public function render(IRenderContext $context): void
    {
        if ($this->hasRenderableComponents()) {
            $this->renderComponents($context);
        } else {
            $context->write($this->getTextContent());
        }
    }
}
