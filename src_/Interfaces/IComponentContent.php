<?php

namespace Atom\Xaml\Interfaces;

interface IComponentContent
{
    public function setTextContent(string $content): void;
    public function getTextContent(): string;
}
