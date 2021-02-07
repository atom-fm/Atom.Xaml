<?php

namespace Atom\Bootstrap;

use Atom\Xaml\Component\Component;

class Page extends Component
{
    public $sidebar = null;

    public function render()
    {
        if ($this->sidebar === null) {
            return new Component(
                "div",
                ["class" => "page my-3 p-3 bg-white rounded shadow-sm"],
                $this->renderChildren()
            );
        }

        return new Component(
            "div",
            ["class" => "page row my-3 p-0 bg-white rounded shadow-sm"],
            [
                new Component("div", ["class" => "col-3 py-2"], [$this->sidebar->render()]),
                new Component("div", ["class" => "col-9"], $this->renderChildren())
            ]
        );
    }
}
