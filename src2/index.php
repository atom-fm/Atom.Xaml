<?php

use Atom\Xaml2\Loader;

include "../vendor/autoload.php";

$viewName = $_GET['view'] ?? "index";

$viewName = "./views/{$viewName}.xml";

$loader = new Loader();
$view = $loader->loadXml($viewName);

$content = $loader->getContent($view);

include "view.php";
