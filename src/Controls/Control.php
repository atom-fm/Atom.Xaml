<?php

namespace Atom\Xaml\Controls;

use Atom\Xaml\Component\Component;
use Atom\Xaml\Component\View;
use Atom\Xaml\Interfaces\IRenderContext;

class Control extends Component
{
    private $template;

    public function __construct(string $template)
    {
        $this->template = $template;
    }

    public function __get($name)
    {
        $result =  $this->getAttribute($name);
        return $result;
    }

    public function content()
    {
        if ($this->hasRenderableComponents()) {
        }
        return $this->getTextContent();
    }

    public function render(IRenderContext $context): void
    {
        $content = $this->renderTemplate($context);
        $context->write($content);
    }

    private function renderTemplate(IRenderContext $context): string
    {
        $view = new View($this, $context);

        $view->content = $context->renderInContext(function ($context) {
            parent::render($context);
        });

        return $context->captureOutput(function () use ($view) {
            include $this->template;
        });
    }
}
