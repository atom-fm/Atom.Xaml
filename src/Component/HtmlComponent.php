<?php

namespace Atom\Xaml\Component;

class HtmlComponent extends TextComponent
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
