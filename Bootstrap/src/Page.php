<?php

namespace Atom\Bootstrap;

use Atom\Xaml\Component\Component;

class Page extends Component
{
    public string $type = "";

    public function render() {
        return new Component("div",["class" => "page"], $this->renderChildren());
    }
}