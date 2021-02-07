<?php

namespace Atom\Bootstrap;

use Atom\Xaml\Component\Component;

class Panel extends Component
{
    public $actions = null;

    public function render()
    {
        if ($this->actions) {
            return new Component(
                "div",
                ["class" => "panel"],
                [
                    $this->renderChildren(),
                    new Component(
                        "div",
                        ["class" => "py-3"],
                        [$this->actions]
                    )
                ]
            );
        }

        return new Component(
            "div",
            ["class" => "panel"],
            $this->renderChildren()
        );
    }
}
