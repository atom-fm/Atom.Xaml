<?php

namespace Atom\Xaml\Interfaces;

interface IComponentProvider
{
    public function createComponent(string $name): ?object;
}
