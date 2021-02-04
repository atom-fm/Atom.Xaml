<?php

namespace Atom\Xaml\Parser;

final class States
{
    public const StartState = 0;
    public const ComponentStart = 1;
    public const ComponentEnd = 2;
    public const CommentStart = 3;
    public const TextStart = 4;
    public const ClosingTag = 5;
}
