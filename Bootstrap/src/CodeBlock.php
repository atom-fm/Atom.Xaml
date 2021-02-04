<?php

namespace Atom\Bootstrap;

use Atom\Xaml\ViewRenderer;
use Atom\Xaml\Component\HtmlComponent;
use Atom\Xaml\Component\Component;

class CodeBlock extends Component
{
    public $lang = "";
    public $title = "";
    public $style = "";

    private function trim($content)
    {
        $content = trim($content, "\r\n");
        $lines = explode("\n", $content);
        $minLen = strlen($content);

        $restLines = array_slice($lines, 1);

        foreach ($restLines as $line) {
            if (trim($line) !== "") {
                $len = $this->indentLength($line);
                $minLen = min($minLen, $len);
            }
        }
        $restLines = array_map(function ($line) use ($minLen) {
            return trim(substr($line, $minLen), "\r\n");
        }, $restLines);

        return implode("\n", [$lines[0], ... $restLines]);
    }

    public function indentLength($line)
    {
        $i = 0;
        while ($i < strlen($line)) {
            if ($line[$i] !== " ") {
                break;
            }
            $i++;
        }
        return $i;
    }

    public function render()
    {
        $content = ViewRenderer::renderComponent($this->renderChildren());
        $content = $this->trim($content);
        $content = htmlentities($content);

        $header = "";
        if ($this->title) {
            $header = "<div class='title'>{$this->title}</div>";
        }

        return new HtmlComponent(<<<HTML
            <div class='code-block' style="{$this->style}">
                $header
                <pre><code class='lang-{$this->lang}'>{$content}</code></pre>
            </div>
        HTML);
    }
}
