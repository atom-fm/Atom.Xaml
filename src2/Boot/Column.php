<?php

namespace Atom\Xaml2\Boot;

use Atom\Xaml2\Component\Component;
use Atom\Xaml2\Component\TextComponent;

class Column extends Component
{
    public string $title = "";
    public string $value = "";

    public function render()
    {
        $children = $this->renderChildren();
        if (count($children) == 0) {
            $children = [
                new TextComponent($this->value)
            ];
        }

        return new Component("td", $this->attributes, $children);
    }

    public function renderHeader()
    {
        return new Component("th", ["scope"=>"col"], [new TextComponent($this->title)]);
    }
}
