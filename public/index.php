<?php

use Atom\Xaml\Loader;
use Atom\Xaml\ViewRenderer;

include "../vendor/autoload.php";
$viewName = $_GET['view'] ?? "index";
$viewName = "./views/{$viewName}.xml";

if (is_file($viewName)) {
    $loader = new Loader();
    $viewRenderer = new ViewRenderer();
    $view = $loader->loadXml($viewName);
    $content = $viewRenderer->getContent($view);
} else {
    $content = "<h3>Error</h3><div class='alert alert-danger'>Missing file <b>{$viewName}</b></div>";
}

include "layouts/layout-nav.php";
