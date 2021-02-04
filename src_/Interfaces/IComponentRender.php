<?php

namespace Atom\Xaml\Interfaces;

interface IComponentRender
{
    public function render(IRenderContext $context): void;
}
