<?php

namespace Atom\Bootstrap;

use Atom\Xaml\Component\Component;
use Atom\Xaml\Component\Fragment;

class Repeat extends Component
{
    public int $rows = 0;

    public function render()
    {
        $rows = [];
        for ($i = 0; $i < $this->rows; $i++) {
            $rows[] = new Fragment($this->renderChildren());
        }

        return new Component("div", $this->attributes, $rows);
    }
}
