<?php

use Atom\Xaml\VDom;

$dom = new VDom("div", ["style" => "border:2px solid red; padding:10px"], [
    new VDom("h2", [], [VDom::text("Hello World")]),
    new VDom(
        "table",
        ["class" => "table"],
        VDom::each(range(1, 10), function ($i) {
            return new VDom("tr", [], [
                new VDom("td", [], [VDom::text("Hello")]),
                new VDom("td", [], [VDom::text("Hello")]),
                new VDom("td", [], [VDom::text("Hello")]),
                new VDom("td", [], [VDom::text("Hello")]),
                new VDom("td", [], [VDom::text("Hello")]),
                new VDom("td", [], [VDom::text("Hello")]),
            ]);
        })
    )
]);

$content = $dom->render();
