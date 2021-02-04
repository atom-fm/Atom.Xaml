<?php

namespace Atom\Xaml\Component;

class Fragment extends Component
{
    public function __construct(array $nodes)
    {
        $this->tag = "";
        $this->nodes = $nodes;
    }

    public function render()
    {
        return $this;
    }
}
