<?php

namespace Atom\Xaml\Parser;

final class TokenTypes
{
    public const OpenTag = 1;
    public const CloseTag = 2;
    public const Equal = 3;
    public const Identifier = 4;
    public const AttributeValue = 5;
    public const AutoCloseTag = 6;
    public const Text = 7;
}
