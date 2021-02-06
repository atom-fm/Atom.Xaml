<?php

namespace Atom\Xaml;

use Atom\Xaml\Component\HtmlComponent;
use Atom\Xaml\Component\TextComponent;

final class ViewRenderer
{
    public function render($component)
    {
        $element = $component->render();
        $this->renderRecursive($element, 0);
    }

    private function renderRecursive($element, $level = 0)
    {
        if ($element === null) {
            return;
        }

        $ident = str_repeat(" ", $level * 4);

        if (is_array($element)) {
            $elements = $element;
            foreach ($elements as $element) {
                $this->renderRecursive($element);
            }
        } else if ($element instanceof HtmlComponent) {
            echo $ident, trim($element->content), "\n";
        } else if ($element instanceof TextComponent) {
            echo $ident, trim($element->content), "\n";
        } else {
            $attributes = HtmlUtils::getAttributes($element);
            $tag = $element->getTag();
            $elements = $element->getNodes();

            if (count($elements) > 0) {
                echo "{$ident}<{$tag}{$attributes}>\n";
                foreach ($elements as $element) {
                    $this->renderRecursive($element, $level + 1);
                }
                echo "{$ident}</{$tag}>\n";
            } else {
                echo "{$ident}<{$tag}{$attributes}></{$tag}>\n";
            }
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

    public static function renderComponent($component)
    {
        $viewRenderer = new ViewRenderer();
        $components = (array)$component;

        $htmlParts = [];
        foreach ($components as $component) {
            $htmlParts[] = $viewRenderer->getContent($component);
        }

        return implode("\n", $htmlParts);
    }
}
