<?php

namespace Atom\Bootstrap;

use Atom\Xaml\Component\Component;

class FormGroup extends Component
{
    public string $type = "";

    public function render()
    {
        return new Component("div", ["class" => "row"], $this->renderChildren());
    }
}
