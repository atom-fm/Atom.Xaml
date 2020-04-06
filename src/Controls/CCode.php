<?php

namespace Atom\Xaml\Controls;

use Exception;
use Atom\Xaml\Component\Component;
use Atom\Xaml\Interfaces\IRenderContext;

class CCode extends Component
{
    public $file = "";
    public $command = "g++ -std=c++17";

    public function render(IRenderContext $context): void
    {
        ob_start();
        try {
            //file_put_contents("program.c", $this->getTextContent());
            echo exec("$this->command $this->file -o program.exe && program.exe");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $content = ob_get_contents();
        ob_clean();
        $context->write($content);
    }
}
