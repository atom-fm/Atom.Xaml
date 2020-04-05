<?php

namespace Atom\Xaml\Controls;

use Atom\Xaml\Component\Component;
use Atom\Xaml\Interfaces\IRenderContext;

class ContentControl extends Component
{
    public function render(IRenderContext $context): void
    {
        //$context->write($this->getTextContent());

        // preg_match_all("/{{(\w+)}}/", $this->content, $matches);
        // $map = [];

        // if (isset($matches[1])) {
        //     $tags = $matches[1];
        //     foreach ($tags as $tag) {
        //         $map["{{".$tag."}}"] = $this->attributes[$tag] ?? "";
        //     }
        // }

        // if ($this->hasRenderableComponents()) {
        //     $map["{{controlContent}}"] = $this->getTextContent();
        //     $map["{{content}}"] = $this->renderClidren();
        // } else {
        //     $map["{{content}}"] = $this->controlContent;
        // }

        // $context->write($this->getTemplate());

        // $result = return strtr($this->content, $map);
    }
}
