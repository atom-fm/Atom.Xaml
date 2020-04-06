<?php

namespace Atom\Xaml;

use Closure;
use SplStack;

final class VDom
{
    public $tag = "";
    public $attributes = [];
    public $nodes = [];
    public $content = "";

    public function __construct(string $tag, array $attributes, array $nodes, string $content = "")
    {
        $this->tag = $tag;
        $this->attributes = $attributes;
        $this->nodes = $nodes;
        $this->content = $content;
    }

    public function render(): string
    {
        if ($this->tag === "#") {
            return $this->content;
        }
        $content = "<{$this->tag}";
        foreach ($this->attributes as $name => $value) {
            $content .= " $name = \"" . htmlentities($value) . "\"";
        }
        $content .= ">\n";

        foreach ($this->nodes as $node) {
            $content .= $node->render();
        }
        $content .= "</{$this->tag}>";
        return $content;
    }

    public function add(iterable $iterable)
    {
        foreach ($iterable as $node) {
            $this->nodes[] = $node;
        }
    }

    public static function html(string $text): VDom
    {
        return new VDom("#", [], [], $text);
    }

    public static function text(string $text): VDom
    {
        return new VDom("#", [], [], htmlentities($text));
    }

    public static function each(iterable $range, Closure $closure): array
    {
        $items = [];
        foreach ($range as $key => $it) {
            $result = $closure($it, $key);
            if ($result) {
                if (is_array($result)) {
                    $items = array_merge($items, $result);
                } else {
                    $items[] = $result;
                }
            }
        }
        return $items;
    }
}
