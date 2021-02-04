<?php

namespace Atom\Xaml;

use Atom\Xaml\Interfaces\IComponentContainer;
use Atom\Xaml\Interfaces\IComponentRender;
use Atom\Xaml\Interfaces\IRenderContext;

class XamlRender implements IRenderContext
{
    private $content = "";

    public function write(string $content)
    {
        $this->content .= $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function createContext(): IRenderContext
    {
        $context = new XamlRender();
        return $context;
    }

    public function render(IComponentRender $component): string
    {
        $component->render($this);
        return $this->getContent();
    }

    public function renderComponent(IComponentRender $component): string
    {
        $context = $this->createContext();
        $component->render($context);
        return $context->getContent();
    }

    public function captureOutput(\Closure $callback, array $params = []): string
    {
        ob_start();
        $callback();
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function renderInContext(\Closure $render)
    {
        $savedContent = $this->content;
        $this->content = "";
        $render($this);
        $result = $this->content;
        $this->content = $savedContent;
        return $result;
    }
}
