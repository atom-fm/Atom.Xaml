<?php

namespace Atom\Xaml\Controls;

use Atom\Xaml\Component\Component;
use Atom\Xaml\Interfaces\IRenderContext;

class Html extends Component
{
    public function render(IRenderContext $context): void
    {
        $context->write($this->getTextContent());
    }
}
