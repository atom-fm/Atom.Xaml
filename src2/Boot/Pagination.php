<?php

namespace Atom\Xaml2\Boot;

use Atom\Xaml2\Component\Component;
use Atom\Xaml2\Component\HtmlComponent;

class Pagination extends Component
{
    public string $type = "";
    public string $errorMessage = "";
    public string $label = "";

    public function render() {
        return new HtmlComponent(<<<HTML
            <nav>
                <ul class="pagination justify-content-end">
                    <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        HTML);
    }
}