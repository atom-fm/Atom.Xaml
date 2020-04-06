<?php

namespace Atom\Xaml\Controls;

use Atom\Xaml\Component\Component;
use Atom\Xaml\Interfaces\IRenderContext;

class Repeat extends Component
{
    public function render(IRenderContext $context): void
    {
        $source = $this->getAttribute("source");

        foreach ($source as $key => $model) {
            $this->setDataContext($model);
            parent::render($context);
        }
    }
}
