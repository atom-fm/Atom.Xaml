<?php

namespace Atom\Bootstrap;

use Atom\Xaml\Component\Component;
use Atom\Xaml\Component\HtmlComponent;
use Atom\Xaml\ViewRenderer;

class Card extends Component
{
    public string $alt = "";
    public string $src = "";
    public string $class = "";
    public string $style = "";

    public function render() {

        $content = ViewRenderer::renderComponent($this->renderChildren());

        return new HtmlComponent(<<<HTML
            <div class="card {$this->class}" style="width: 18rem; {$this->style}">
                <img class="card-img-top" src="{$this->src}" alt="{$this->alt}">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <div class="card-text">
                        {$content}
                    </div>
                </div>
            </div>
        HTML);
    }
}