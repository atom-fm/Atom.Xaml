<?php

namespace Atom\Xaml;

use Atom\Xaml\Controls\Control;
use ReflectionClass;
use RuntimeException;
use Atom\Xaml\Parser\Node;
use Atom\Xaml\Parser\XamlLexer;
use Atom\Xaml\Parser\XamlParser;
use Atom\Xaml\Interfaces\IComponentContent;
use Atom\Xaml\Interfaces\IComponentContainer;
use Atom\Xaml\Interfaces\IComponentAttributes;
use Atom\Xaml\Interfaces\IComponentTemplate;

class XamlBuilder
{
    private $components = [];

    public function component(string $name, string $class)
    {
        $this->components[$name] = $class;
    }

    public function parseFile(string $fileName)
    {
        $source = file_get_contents($fileName);
        return $this->parse($source);
    }

    public function parse(string $source)
    {
        $lexer = new XamlLexer();
        $parser = new XamlParser($lexer->parse($source));
        $compnent = $parser->parse();
        return $this->createComponent($compnent);
    }

    private function isTemplate(string $name): bool
    {
        return strpos($name, ".php") !== false;
    }

    public function createComponent(Node $node)
    {
        $type = $this->components[$node->name] ?? null;

        if ($type === null) {
            throw new RuntimeException("Component {$node->name} is not found.");
        }

        if ($this->isTemplate($type)) {
            $componentFile = $type;
            $instance = new Control($componentFile);
            $this->assign($instance, $node);
            return $instance;
        }

        $reflection = new ReflectionClass($type);
        $instance = $reflection->newInstance();
        $this->assign($instance, $node);
        return $instance;
    }

    public function assign(object $instance, Node $node)
    {
        if ($instance instanceof IComponentContainer) {
            foreach ($node->getChildNodes() as $childNode) {
                $child = $this->createComponent($childNode);
                $instance->addComponent($child);
            }
        }

        $content = $node->getTextContent();
        if ($content) {
            if ($instance instanceof IComponentContent) {
                $instance->setTextContent($content);
            }

            if ($instance instanceof IComponentTemplate) {
                $instance->setTemplate($content);
            }
        }

        if ($instance instanceof IComponentAttributes) {
            $instance->setAttributes($node->getAttributes());
        }
        $this->setProperties($instance, $node->getAttributes());
    }

    public function setProperties(object $instance, array $attributes)
    {
        $reflection = new ReflectionClass($instance);

        foreach ($attributes as $propertyName => $value) {
            $setter = "set{$propertyName}";
            if ($reflection->hasMethod($setter)) {
                $setter = $reflection->getMethod($setter);
                $setter->invoke($instance, $value);
            } elseif ($reflection->hasProperty($propertyName)) {
                $property = $reflection->getProperty($propertyName);
                if ($property->isPublic()) {
                    $property->setValue($instance, $value);
                }
            }
        }
    }
}
