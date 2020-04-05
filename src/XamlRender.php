<?php

namespace Atom\Xaml;

use Atom\Xaml\Interfaces\IRenderContext;

class XamlRender implements IRenderContext
{
    private $content;

    public function write(string $content)
    {
        $this->content .= $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
