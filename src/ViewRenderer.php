<?php

namespace Atom\Xaml;

use Atom\Xaml\Component\Component;
use Atom\Xaml\Component\Fragment;
use Atom\Xaml\Component\TextComponent;

class ViewRenderer
{
    public function render($component)
    {
        $dom = $component->render();
        $this->renderNode($dom, 0);
    }

    public static function renderComponent($component) {
        $viewRenderer = new ViewRenderer();

        if (!is_array($component)) {
            $components = [$component];
        } else {
            $components = $component;
        }

        $htmlParts = [];
        foreach($components as $component) {
            $htmlParts[] = $viewRenderer->getContent($component);
        }

        return implode("\n", $htmlParts);
    }

    private function getAttributes(Component $node) {
        $result = "";
        foreach ($node->getAttributes() as $key => $value) {
            $value = htmlspecialchars($value);
            $result .= " $key=\"$value\"";
        }
        return $result;
    }

    private function renderNode($node, $level = 0)
    {
        $prefix = str_repeat(" ", $level*4);

        if ($node === null) {
            return;
        }

        if ($node instanceof TextComponent) {
            echo $prefix, trim($node->content), "\n";
            return;
        }

        if ($node instanceof Fragment) {
            $nodes = $node->getNodes();

            foreach($nodes as $node) {
                $this->renderNode($node);
            }

            return;
        }

        $attributes = $this->getAttributes($node);
        $tag = $node->getTag();
        $nodes = $node->getNodes();

        if (count($nodes) > 0) {
            echo "{$prefix}<{$tag}{$attributes}>\n";
            foreach ($nodes as $node) {
                $this->renderNode($node, $level+1);
            }
            echo "{$prefix}</{$tag}>\n";
        } else {
            echo "{$prefix}<{$tag}{$attributes}></{$tag}>\n";
        }
    }

    public function getContent($component)
    {
        ob_start();
        $this->render($component);
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
}