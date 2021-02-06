<?php

namespace Atom\Bootstrap;

use Atom\Xaml\Component\Component;

class DataTable extends Component
{
    public string $table = "";
    public int $size = 20;
    public int $page = 1;

    public function render()
    {
        $cols = [];
        $rows = [];
        $fields = [];

        $columns = $this->getNodesOfType(Column::class);

        foreach ($columns as $node) {
            $cols[] = $node->renderHeader();
            if ($node->field) {
                $fields[] = $node->field;
            }
        }

        $start = ($this->page - 1) * $this->size;

        $sql = "SELECT * FROM {$this->table} LIMIT {$start}, {$this->size}";
        $data = (new \App\Database())->queryAll($sql);

        foreach($data as $row) {
            $rowCols = [];
            foreach ($columns as $node) {
                $node->value = $row[$node->field] ?? "";
                $rowCols[] = $node->render();
            }
            $rows[] = new Component("tr", [], $rowCols);
        }

        return new Component(
            "table",  
            $this->mergeAttributes(["class" => "table table-sm"]),
            [
                new Component("thead", [], [
                    new Component("tr", [], $cols)
                ]),
                new Component("tbody", [], $rows)
            ]
        );
    }
}
