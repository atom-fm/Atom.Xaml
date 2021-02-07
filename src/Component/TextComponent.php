<?php

namespace Atom\Xaml\Component;

class TextComponent extends Element
{
    public string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function render()
    {
        return $this;
    }
}
