<?php

use Atom\Xaml\XamlRender;
use Atom\Xaml\XamlBuilder;
use Atom\Xaml\ComponentProvider;

include "../vendor/autoload.php";


$builder = new XamlBuilder();
$componentProvider = new ComponentProvider();
$componentProvider->addDirectory(dirname(__DIR__) ."/Bootstrap");
$componentProvider->addNamespace("Atom\\Xaml\\Controls");
$builder->addProvider($componentProvider);

$component = $builder->parse(file_get_contents("Template2.xaml"));

class Item
{
    public $title;
    public $message;
    public function __construct($title="", $message="")
    {
        $this->title = $title;
        $this->message = $message;
    }
}

class Model
{
    public $title = "This is model";
    public $description = "This is description";
    public $items = [];
}

$model = new Model();
$model->items = [
    new Item("info", "This is message A"),
    new Item("success", "This is message B"),
    new Item("danger", "This is message C"),
    new Item("warning", "This is message D"),
    new Item("primary", "This is message E"),
];

$component->setDataContext($model);
$context = new XamlRender;
$content = $context->render($component);


include "View.php";
