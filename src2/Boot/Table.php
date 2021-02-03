<?php

namespace Atom\Xaml2\Boot;

use Atom\Xaml2\Component\Component;

class Table extends Component
{
    public int $rows = 0;

    public function render()
    {
        $cols = [];
        $rows = [];

        foreach ($this->nodes as $node) {
            if ($node instanceof Column) {
                $cols[] = $node->renderHeader();
            }
        }

        for ($i = 0; $i < $this->rows; $i++) {
            $rowCols = [];
            foreach ($this->nodes as $node) {
                if ($node instanceof Column) {
                    $rowCols[] = $node->render();
                }
            }
            $rows[] = new Component("tr", [], $rowCols);
        }

        return new Component(
            "table",
            $this->attributes,
            [
                new Component("thead", [], [
                    new Component("tr", [], $cols)
                ]),
                new Component("tbody", [], $rows)
            ],
        );
    }
}
