<?php

namespace Atom\Xaml\Interfaces;

interface IComponentContainer
{
    public function addComponent(object $item): void;
    public function getComponents(): array;
}
