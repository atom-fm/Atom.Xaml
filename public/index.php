<?php

use Atom\Xaml\Loader;
use Atom\Xaml\ViewRenderer;

include "../vendor/autoload.php";
include "../app/config.php";

$viewName = $_GET['view'] ?? "index";
$viewName = "../app/Views/{$viewName}.xml";

if (is_file($viewName)) {
    $loader = new Loader();
    $viewRenderer = new ViewRenderer();
    $view = $loader->loadXml($viewName);
    $content = $viewRenderer->getContent($view);
} else {
    $content = "<h3>Error</h3><div class='alert alert-danger'>Missing file <b>{$viewName}</b></div>";
}

include "../app/Layouts/layout-nav.php";
