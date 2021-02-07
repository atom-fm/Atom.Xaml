<?php

namespace Atom\Xaml;

use Atom\Xaml\Component\Component;

final class HtmlUtils
{
    private static $selfClosingTags = [
        "area",
        "base",
        "br",
        "col",
        "embed",
        "hr",
        "img",
        "input",
        "link",
        "meta",
        "param",
        "source",
        "track",
        "wbr"
    ];

    public static function isSelfClosingTag($tag): bool
    {
        return in_array($tag, self::$selfClosingTags);
    }

    public static function getAttributes(Component $component): string
    {
        $result = "";
        foreach ($component->getAttributes() as $key => $value) {
            $value = htmlspecialchars($value);
            $result .= " $key=\"$value\"";
        }
        return $result;
    }

    public static function mergeAttributes(array $attributes, array $extraAttribues)
    {
        foreach ($extraAttribues as $key => $value) {
            if ($key === "class") {
                $attributes[$key] = self::mergeClasses($attributes[$key], $value);
            } else {
                $attributes[$key] = $value;
            }
        }
        return $attributes;
    }

    public static function mergeClasses($classes, $extraClasses)
    {
        $classList = explode(" ", $classes ?? "");
        $extraClassList = explode(" ", $extraClasses ?? "");
        $result = array_unique(array_merge($classList, $extraClassList));
        return implode(" ", $result);
    }
}
