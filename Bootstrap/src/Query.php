<?php

namespace Atom\Bootstrap;

use Atom\Xaml\Component\Component;
use Atom\Xaml\Component\TextComponent;
use Atom\Xaml\ViewRenderer;

class Query extends Component
{
    public function render()
    {
        $sql = ViewRenderer::renderComponent($this->renderChildren());

        $data = $this->queryData($sql);
        if (count($data)) {

            $keys = array_keys($data[0]);
            $columns = [];
            $rows = [];

            foreach ($keys as $key) {
                $columns[] = new Component("th", [], [new TextComponent($key)]);
            }

            $tableRows = [];

            foreach ($data as $row) {
                $tableRow = [];
                foreach ($keys as $key) {
                    $value = $row[$key] ?? "";
                    $tableRow[] = new Component("td", [], [new TextComponent($value)]);
                }
                $tableRows[] = new Component("tr", [], $tableRow);
            }


            $header = new Component("tr", [], $columns);
            return new Component("table", ["class" => "table table-sm"], [
                $header,
                ...$tableRows
            ]);
        }
    }

    private function queryData($sql)
    {
        $db = new \App\Database();
        return $db->queryAll($sql);
    }
}
