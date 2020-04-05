<?php

namespace Atom\Xaml\Controls;

use Atom\Xaml\Component\Component;
use Atom\Xaml\Interfaces\IRenderContext;

class Entery extends Component
{
    public $field = "";
    public $title = "";
    public $message = "";
    public $type = "text";
    public $placeholder = "";

    public function render(IRenderContext $context): void
    {
        $code = <<<HTML
            <label for="{$this->field}">{$this->title}</label>
            <input type="{$this->type}" class="form-control" id="{$this->field}" placeholder="{$this->placeholder}">
            <small id="{$this->field}" class="form-text text-muted">{$this->message}</small>
        HTML;
        $context->write($code);
    }
}
