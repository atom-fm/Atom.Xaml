<?php

namespace Atom\Xaml\Controls;

use Atom\Xaml\Component\Component;
use Atom\Xaml\Interfaces\IRenderContext;

class Form extends Component
{
    public $method;

    public function render(IRenderContext $context): void
    {
        $context->write("<form>");
        $this->renderComponents($context);
        $context->write("</form>");
    }
}
