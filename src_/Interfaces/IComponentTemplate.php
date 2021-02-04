<?php

namespace Atom\Xaml\Interfaces;

interface IComponentTemplate
{
    public function setTemplate(string $template): void;
    public function getTemplate(): string;
}
