<?php

namespace Atom\Xaml\Interfaces;

interface IComponentAttributes
{
    public function setAttributes(array $attributes): void;
    public function getAttributes(): array;
    public function getAttribute(string $name, $default=null);
}
