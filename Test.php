<?php

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
use Atom\Xaml\Controls\ContentControl;
use Atom\Xaml\XamlRender;

include "vendor/autoload.php";

$builder = new XamlBuilder();

$builder->component("Component", Component::class);
$builder->component("Repeat", Repeat::class);
$builder->component("ContentControl", ContentControl::class);
$builder->component("PhpCode", PhpCode::class);
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

$result = $builder->parse(file_get_contents("Template.xaml"));

$context = new XamlRender;
$result->render($context);

$content = $context->getContent();

include "View.php";
