<?php

namespace Atom\Xaml2\Boot;

use Atom\Xaml2\Component\Component;

class FormGroup extends Component
{
    public string $type = "";

    public function render() {
        return new Component("div", ["class" => "row"], $this->renderChildren());
    }
}