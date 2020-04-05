<?php

namespace Atom\Xaml\Component;

use Atom\Xaml\Interfaces\IRenderContext;
use Atom\Xaml\Interfaces\IComponentRender;
use Atom\Xaml\Interfaces\IComponentContent;
use Atom\Xaml\Interfaces\IComponentContainer;
use Atom\Xaml\Interfaces\IComponentAttributes;

class Component implements IComponentContent, IComponentContainer, IComponentAttributes, IComponentRender
{
    private $attributes = [];
    private $components = [];
    private $textContent = "";

    public function getComponents(): array
    {
        return $this->components;
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

    public function renderComponents(IRenderContext $context): bool
    {
        $didRender = false;
        foreach ($this->components as $component) {
            if ($component instanceof IComponentRender) {
                $component->render($context);
                $didRender = true;
            }
        }
        return $didRender;
    }

    public function render(IRenderContext $context): void
    {
        $didRender = $this->renderComponents($context);
        if (!$didRender) {
            $context->write($this->getTextContent());
        }
    }
}
