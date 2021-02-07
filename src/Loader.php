<?php

namespace Atom\Xaml;

use Atom\Xaml\Component\Component;
use Atom\Xaml\Component\TextComponent;

use DOMDocument;
use DOMElement;
use DOMText;
use DOMXPath;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;


class ComponentFactory
{
}

class Loader
{
    private $namespaces = [];

    public function loadXml($file)
    {
        $doc = new DOMDocument();
        $doc->loadXML(file_get_contents($file));
        $this->namespaces = $this->getNamespaces($doc);
        $result = $this->transformTree($doc->documentElement);
        return $result;
    }

    public function getComponentClassName($tag)
    {
        $parts = explode(":", $tag);
        if (count($parts) == 2) {
            $ns = $this->namespaces[$parts[0]] ?? null;
            if ($ns === null) {
                throw new RuntimeException("Namespace $ns is not defined");
            }
            $className = $parts[1];
            $className = "$ns.$className";
            $className = str_replace(".", "\\", $className);
            return $className;
        }
        $className = $parts[0];
        $className = str_replace(".", "\\", $className);
        return $className;
    }

    public function getNamespaces($doc)
    {
        $result = [];
        $xpath = new DOMXPath($doc);
        foreach ($xpath->query('namespace::*', $doc->documentElement) as $key => $node) {
            $result[$node->prefix] = $node->namespaceURI;
        }
        return $result;
    }

    // public function walkTree($root, $level = 1)
    // {
    //     if ($root instanceof DOMText) {
    //         $content = trim($root->textContent);
    //         if ($content) {
    //             echo str_repeat(" ", $level * 4), " => ", "Text: ", trim($root->textContent), "\n";
    //         }
    //     } else {
    //         $attributes = [];
    //         foreach ($root->attributes as $key => $attribute) {
    //             $attributes[$key] = $attribute->nodeValue;
    //         }
    //         $data = [];

    //         foreach ($attributes as $key => $value) {
    //             $data[] = "\"$key\" => \"$value\"";
    //         }
    //         $text = implode(", ", $data);

    //         echo str_repeat(" ", $level * 4), " => ", "Tag: ", $root->tagName,  " [$text]", "\n";
    //     }

    //     foreach ($root->childNodes as $node) {
    //         $this->walkTree($node, $level + 1);
    //     }
    // }

    private function getAttributes(DOMElement $node)
    {
        $attributes = [];
        foreach ($node->attributes as $key => $attribute) {
            $attributes[$key] = $attribute->nodeValue;
        }
        return $attributes;
    }

    public function transformTree($root, $level = 1)
    {
        $newNode = null;
        if ($root instanceof DOMText) {
            $content = trim($root->textContent);
            if ($content) {
                $newNode = new TextComponent($root->textContent);
            }
        } elseif ($root instanceof DOMElement) {
            $attributes = $this->getAttributes($root);
            $slots = [];
            $nodes = [];
            foreach ($root->childNodes as $node) {
                $newChildNode = $this->transformTree($node, $level + 1);
                if ($newChildNode) {
                    if ($newChildNode instanceof Component && $newChildNode->hasAttribute("slot")) {
                        $slotName = $newChildNode->getAttribute("slot");
                        $slots[$slotName] = $newChildNode;
                    } else {
                        $nodes[] = $newChildNode;
                    }
                }
            }
            $tagName = $root->tagName;
            $className = $this->getComponentClassName($tagName);

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);
                $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
                $props = [];

                foreach ($properties as $property) {
                    if (isset($attributes[$property->name])) {
                        $value = $attributes[$property->name];
                        $props[$property->name] = $value;
                        unset($attributes[$property->name]);
                    }
                }
                $newNode = $reflection->newInstance($tagName, $attributes, $nodes);

                foreach ($props as $prop => $value) {
                    $newNode->{$prop} = $value;
                }

                foreach ($slots as $slotName => $slot) {
                    $newNode->{$slotName} = $slot;
                }

                return $newNode;
            } else {
                $newNode = new Component($tagName, $attributes, $nodes);
            }
        }

        return $newNode;
    }
}
