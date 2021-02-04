<?php

namespace Atom\Bootstrap;

use Atom\Xaml\Component\HtmlComponent;
use Atom\Xaml\Component\Component;
use Atom\Xaml\Component\Fragment;

class Form extends Component
{
    public string $title = "";

    public function render()
    {
        return new Component(
            "form",
            $this->getAttributes(),
            [
                new HtmlComponent("<h2>{$this->title}</h2>"),
                new Component("div", ["class" => "form-content"],$this->renderChildren())
            ]
        );
    }
}