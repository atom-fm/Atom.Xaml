<?php

namespace Atom\Xaml\Interfaces;

interface IComponentParent
{
    public function setParent(object $component): void;
    public function getParent(): ?object;
}
