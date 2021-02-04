<?php

namespace Atom\Bootstrap;

use Atom\Xaml\Component\Component;
use Atom\Xaml\Component\HtmlComponent;

class Entry extends Component
{
    public string $id = "";
    public string $name = "";
    public string $type = "text";
    public string $message = "";
    public string $errorMessage = "";
    public string $successMessage = "";
    public string $label = "";
    public $source = [];

    public function render() {

        $id = $this->id;
        $class = $this->getAttribute("class");

        if ($this->type === "select")
        {
            return new HtmlComponent(<<<HTML
                <div class="form-group {$class}">
                    <label for="{$id}">{$this->label}</label>
                    <select class="form-control" id="{$id}">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
            HTML);
        }

        if ($this->type === "checkbox")
        {
            return new HtmlComponent(<<<HTML
                <div class="form-check {$class}">
                    <input type="{$this->type}" class="form-check-input" id="{$id}" placeholder="{$this->label}" />
                    <label lass="form-check-label" for="{$id}">{$this->label}</label>
                </div>
            HTML);
        }

        return new HtmlComponent(<<<HTML
            <div class="form-group {$class}">
                <label for="{$id}">{$this->label}</label>
                <div class="input-group">
                    <input type="{$this->type}" class="form-control" id="{$id}" placeholder="{$this->label}" />
                </div>
                <small id="{$id}Help" class="form-text text-muted">{$this->message}</small>
            </div>
        HTML);
    }
}