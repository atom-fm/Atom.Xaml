<?php

namespace Atom\Xaml\Interfaces;

interface IComponentProvider
{
    public function hasComponent(string $name): bool;
}
