<?php

namespace Atom\Xaml\Controls;

use Exception;
use Atom\Xaml\Component\Component;
use Atom\Xaml\Interfaces\IRenderContext;

class PhpCode extends Component
{
    public function render(IRenderContext $context): void
    {
        ob_start();
        try {
            eval($this->content);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $content = ob_get_contents();
        ob_clean();
        $context->write($content);
    }
}
