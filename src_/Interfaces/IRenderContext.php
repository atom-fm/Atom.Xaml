<?php

namespace Atom\Xaml\Interfaces;

use Closure;

interface IRenderContext
{
    // public function save(): void;
    // public function restore(): string;
    // public function commit(): bool;
    public function write(string $content);
    public function createContext(): IRenderContext;
    public function getContent(): string;
    public function render(IComponentRender $component): string;
    public function renderComponent(IComponentRender $component): string;
    public function captureOutput(Closure $callback): string;
    public function renderInContext(Closure $render);
}
