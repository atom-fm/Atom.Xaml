<?php

namespace Atom\Xaml\Controls;

use Atom\Xaml\Component\Component;
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
        return $this->getAttribute($name);
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
        ob_start();
        try {
            include $this->template;
        } catch (\Error $e) {
            echo $e->getMessage();
        }
        $content = ob_get_contents();
        ob_clean();
        return $content;
    }
}
