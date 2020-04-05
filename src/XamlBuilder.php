<?php

namespace Atom\Xaml;

use ReflectionClass;
use RuntimeException;
use Atom\Xaml\Parser\Node;
use Atom\Xaml\Controls\Control;
use Atom\Xaml\Parser\XamlLexer;
use Atom\Xaml\Parser\XamlParser;
use Atom\Xaml\Component\Component;
use Atom\Xaml\Interfaces\IComponentContent;
use Atom\Xaml\Interfaces\IComponentProvider;
use Atom\Xaml\Interfaces\IComponentTemplate;
use Atom\Xaml\Interfaces\IComponentContainer;
use Atom\Xaml\Interfaces\IComponentAttributes;

class XamlBuilder
{
    private $components = [];
    private $providers = [];

    public function addProvider(IComponentProvider $provider): void
    {
        $this->providers[] = $provider;
    }

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
        if ($node->isProperty()) {
            $instance = new Component();
            $this->assign($instance, $node);
            return $instance;
        } else {
            $type = $this->components[$node->getName()] ?? null;

            if ($type === null) {
                throw new RuntimeException("Component {$node->getName()} is not found.");
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
    }

    public function assign(object $instance, Node $node)
    {
        if ($instance instanceof IComponentContainer) {
            foreach ($node->getChildNodes() as $childNode) {
                if ($childNode->isComponent()) {
                    $child = $this->createComponent($childNode);
                    $instance->addComponent($child);
                }
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

        $attributes = $this->getAttributes($node);

        if ($instance instanceof IComponentAttributes) {
            $instance->setAttributes($attributes);
        }

        $this->setProperties($instance, $attributes);
    }

    public function getAttributes(Node $node): array
    {
        $attributes = $node->getAttributes();
        foreach ($attributes as $key => $attribute) {
            if ($attribute instanceof Node) {
                if ($attribute->hasChildNodes()) {
                    $component = new Component();
                    $this->assign($component, $attribute);
                    $attributes[$key] = $component;
                } else {
                    $attributes[$key] = $attribute->getTextContent();
                }
            }
        }
        return $attributes;
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
