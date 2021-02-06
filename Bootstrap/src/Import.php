<?php

namespace Atom\Bootstrap;

use Atom\Xaml\Component\Component;
use Atom\Xaml\Component\HtmlComponent;
use Atom\Xaml\Loader;

class Import extends Component
{
    public string $name = "";

    public function render()
    {
        $viewName = str_replace(".", "/", $this->name);
        $viewName = "../app/Views/{$viewName}.xml";

        if (is_file($viewName)) {
            $loader = new Loader();
            $view = $loader->loadXml($viewName);
            return $view->render();
        } else {
            return new HtmlComponent("<h3>Error</h3><div class='alert alert-danger'>Missing file <b>{$viewName}</b></div>");
        }
    }
}
