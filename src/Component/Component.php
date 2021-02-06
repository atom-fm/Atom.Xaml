<?php

namespace Atom\Xaml\Component;

class Component extends Element
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

    protected function mergeAttributes(array $attributes)
    {
        $result = $this->getAttributes();
        foreach ($attributes as $key => $value) {
            switch ($key) {
                case "class":
                    //TODO: Merge class
                    $result["class"] = $value;
                    break;
                case "style":
                    //TODO: Merge style
                    $result["style"] = $value;
                    break;
                default:
                    $result[$key] = $value;
            }
        }
        return $result;
    }

    public function getAttribute($name)
    {
        return $this->attributes[$name] ?? "";
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getNodesOfType($classType)
    {
        return array_filter( $this->nodes, function($item) use ($classType) {
            return $item instanceof $classType;
        }) ;
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

    /**
     * @return mixed
     */
    public function render()
    {
        if (
            strpos($this->tag, ":") !== false ||
            strpos($this->tag, ".") !== false ||
            strtolower($this->tag) !== $this->tag
        ) {
            return new Component(
                "div",
                $this->attributes + ["style" => "border:2px red solid; background:#FFEEEE; padding:5px;text-align:center;margin:5px 0px"],
                [new HtmlComponent("Missing component <b>{$this->tag}</b>")]
            );
        }
        return new Component($this->tag, $this->attributes, $this->renderChildren());
    }
}
