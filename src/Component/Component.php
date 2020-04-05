<?php

namespace Atom\Xaml\Component;

use Atom\Xaml\Interfaces\IRenderContext;
use Atom\Xaml\Interfaces\IComponentParent;
use Atom\Xaml\Interfaces\IComponentRender;
use Atom\Xaml\Interfaces\IComponentContent;
use Atom\Xaml\Interfaces\IComponentContainer;
use Atom\Xaml\Interfaces\IComponentAttributes;

class Component implements IComponentContent, IComponentContainer, IComponentAttributes, IComponentRender, IComponentParent
{
    private $parent = null;
    private $attributes = [];
    private $components = [];
    private $textContent = "";

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

    public function getAttribute(string $name, $default = null)
    {
        return $this->attributes[$name] ?? $default;
    }

    public function addComponent(object $component): void
    {
        $this->components[] = $component;
    }

    public function setTextContent(string $content): void
    {
        $this->textContent = $content;
    }

    public function getTextContent(): string
    {
        return $this->textContent;
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
