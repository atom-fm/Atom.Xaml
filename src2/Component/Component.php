<?php

namespace Atom\Xaml2\Component;

class Component
{
    protected string $tag;
    protected array $attributes = [];
    protected array $nodes = [];

    public function __construct(string $tag, array $attributes, array $nodes)
    {
        $this->tag = $tag;
        $this->attributes = $attributes;
        $this->nodes = $nodes;
    }

    public function getAttribute($name)
    {
        return $this->attributes[$name] ?? "";
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getNodes()
    {
        return $this->nodes;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function renderChildren()
    {
        $result = [];
        foreach ($this->nodes as $node) {
            $result[] = $node->render();
        }
        return $result;
    }

    public function render()
    {
        if (strpos($this->tag, ":") !== false ||
            strpos($this->tag, ".") !== false ||
            strtolower($this->tag) !== $this->tag) {
            return new Component(
                "div",
                $this->attributes + ["style" => "border:2px red solid; background:#FFEEEE; padding:5px;text-align:center;margin:5px 0px"],
                [new HtmlComponent("Missing component <b>{$this->tag}</b>")]
            );
        } else {
            return new Component($this->tag, $this->attributes, $this->renderChildren());
        }
    }
}
