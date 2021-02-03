<?php

namespace Atom\Xaml2\Boot;

use Atom\Xaml2\Component\Component;

class Alert extends Component
{
    public string $type = "";

    public function render() {
        return new Component("div", ["class" => "alert alert-{$this->type}"], $this->renderChildren());
    }
}