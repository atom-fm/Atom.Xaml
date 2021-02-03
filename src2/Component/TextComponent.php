<?php

namespace Atom\Xaml2\Component;

class TextComponent
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
