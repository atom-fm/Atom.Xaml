<?php

class Model {
    public $hello = "Hello";
    public $world = "World";
}

class Binder 
{
    private $content;
    private $model;
    private $matches;

    public function __construct($content) 
    {
        $this->content = $content;
        preg_match_all("/{{.*?}}/", $content,  $result, 
            PREG_SET_ORDER | PREG_OFFSET_CAPTURE
        );
        $this->matches = $result;
    }

    public function setModel($model) {
        $this->model = $model;
    }

    public function getResult() 
    {
        print_r($this);
    }
}

$binder = new Binder("This is some text {{ hello }} {{ world }}");
$binder->setModel(new Model());

echo $binder->getResult();
