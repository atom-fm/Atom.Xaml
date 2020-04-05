<?php

namespace Atom\Xaml\Parser;

final class Token
{
    public $token ;
    public $tokenType;
    public $start;
    public $line;

    public function __construct(string $token, $tokenType, int $start, int $line = 0)
    {
        $this->token = $token;
        $this->tokenType = $tokenType;
        $this->start = $start;
        $this->line = $line;
    }
}
