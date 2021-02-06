<?php

namespace Atom\Bootstrap;

use Atom\Xaml\Component\Component;

class Repeat extends Component
{
    public int $rows = 0;

    public function render()
    {
        $rows = [];

        for ($i = 0; $i < $this->rows; $i++) {
            $rows[] = $this->renderChildren();
        }

        return new Component("div", $this->attributes, $rows);
    }
}
