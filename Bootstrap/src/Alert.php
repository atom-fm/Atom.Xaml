<?php

namespace Atom\Bootstrap;

use Atom\Xaml\Component\Component;

class Alert extends Component
{
    public string $type = "";

    public function render() {
        return new Component(
            "div",
            $this->mergeAttributes([
                "class" => "alert alert-{$this->type}"
            ]),
            $this->renderChildren()
        );
    }
}