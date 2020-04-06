<?php

use Atom\Xaml\XamlRender;
use Atom\Xaml\XamlBuilder;
use Atom\Xaml\Controls\Code;
use Atom\Xaml\Controls\Form;
use Atom\Xaml\Controls\Html;
use Atom\Xaml\Controls\Page;
use Atom\Xaml\Controls\Table;
use Atom\Xaml\Controls\Entery;
use Atom\Xaml\Controls\Repeat;
use Atom\Xaml\Controls\PhpCode;
use Atom\Xaml\Component\Component;
use Atom\Xaml\Controls\CCode;
use Atom\Xaml\VDom;

include "vendor/autoload.php";


$builder = new XamlBuilder();

$builder->component("Component", Component::class);
$builder->component("Repeat", Repeat::class);
$builder->component("PhpCode", PhpCode::class);
$builder->component("CCode", CCode::class);
$builder->component("Page", Page::class);
$builder->component("Form", Form::class);
$builder->component("Code", Code::class);
$builder->component("Entery", Entery::class);
$builder->component("Html", Html::class);
$builder->component("Table", Table::class);

$builder->component("Alert", __DIR__ ."/Bootstrap/Alert.php");
$builder->component("Button", __DIR__ ."/Bootstrap/Button.php");
$builder->component("FormGroup", __DIR__ ."/Bootstrap/FormGroup.php");
$builder->component("Note", __DIR__ ."/Bootstrap/Note.php");

$component = $builder->parse(file_get_contents("Template.xaml"));

class Item
{
    public $title;
    public $message;
    public function __construct($title, $message)
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
