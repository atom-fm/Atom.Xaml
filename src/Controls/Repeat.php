<?php

namespace Atom\Xaml\Controls;

use Atom\Xaml\Component\Component;
use Atom\Xaml\Interfaces\IRenderContext;

class Repeat extends Component
{
    public $count = 10;

    public function render(IRenderContext $context): void
    {
        $n = (int)$this->count;
        $context->write("<div style='display:flex;flex-flow:wrap'>");
        for ($i = 0; $i < $n; $i++) {
            $context->write("<div style='margin:10px'>");
            $this->renderComponents($context);
            $context->write("</div>");
        }
        $context->write("</div>");
    }
}
