<?php

namespace Atom\Xaml\Controls;

use Atom\Xaml\Component\Component;
use Atom\Xaml\Interfaces\IRenderContext;

class Table extends Component
{
    public $rows = 10;
    public $title = "";

    public function render(IRenderContext $context): void
    {
        $rows = (int)$this->rows;
        $result = "<h2>{$this->title}</h2><table class='table table-condensed'>";
        for ($i = 0; $i < $rows; $i++) {
            $result .=
            "<tr>
                <td> {$i}. </td>
                <td> Hello </td>
                <td> Hello </td>
                <td> Hello </td>
            </tr>";
        }
        $result .= "</table>";
        $context->write($result);
    }
}
