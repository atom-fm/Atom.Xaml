<?php

namespace Atom\Xaml\Controls;

use Atom\Xaml\Component\Component;
use Atom\Xaml\Interfaces\IRenderContext;

class Code extends Component
{
    public $lang;
    public $title = "";

    private function trim($content)
    {
        $content = trim($content, "\r\n");
        $lines = explode("\n", $content);
        $minLen = strlen($content);
        foreach ($lines as $line) {
            if (trim($line) !== "") {
                $len = $this->indentLength($line);
                $minLen = min($minLen, $len);
            }
        }
        $lines = array_map(function ($line) use ($minLen) {
            return trim(substr($line, $minLen), "\r\n");
        }, $lines);
        return implode("\r", $lines);
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

    public function render(IRenderContext $context): void
    {
        $content = $this->trim($this->getTextContent());
        $content = htmlentities($content);

        $header = "";
        if ($this->title) {
            $header = "<div class='title'>{$this->title}</div>";
        }
        $code = <<<HTML
            <div class='code-block'>
                $header
                <pre><code class='lang-{$this->lang}'>{$content}</code></pre>
            </div>
        HTML;
        $context->write($code);
    }
}
