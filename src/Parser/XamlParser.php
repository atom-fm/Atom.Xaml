<?php

namespace Atom\Xaml\Parser;

use RuntimeException;

class XamlParser
{
    private $tokens = [];
    private $at = 0;
    private $end = 0;

    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
        $this->at = 0;
        $this->end = count($this->tokens);
    }

    public function isEof(): bool
    {
        return $this->at >= $this->end;
    }

    public function tok(): Token
    {
        return $this->tokens[$this->at];
    }

    public function anyOf(array $tokenTypes): ?Token
    {
        $tok = $this->tok();
        if (in_array($tok->tokenType, $tokenTypes, true)) {
            $this->at++;
            return $tok;
        }
        return null;
    }

    public function expect(array $tokenTypes): Token
    {
        $tok = $this->tok();
        if (in_array($tok->tokenType, $tokenTypes, true)) {
            $this->at++;
            return $tok;
        }
        throw new RuntimeException("Unexpected token type");
    }

    public function parse()
    {
        return $this->parseComponent();
    }

    public function parseComponent(): Node
    {
        $node = new Node();
        $this->expect([TokenTypes::OpenTag]);
        $id = $this->expect([TokenTypes::Identifier]);
        $attributes = $this->parseAttributes();
        $tok = $this->expect([TokenTypes::CloseTag, TokenTypes::AutoCloseTag]);

        $node->name = $id->token;
        $node->attributes = $attributes;

        if ($tok->tokenType == TokenTypes::AutoCloseTag) {
            return $node;
        }

        while (!$this->isEof()) {
            $tok = $this->tok();
            if ($tok->tokenType === TokenTypes::OpenTag) {
                $node->nodes[] = $this->parseComponent();
            } elseif ($tok->tokenType == TokenTypes::Text) {
                $node->content = $tok->token;
                $this->at++;
            } else {
                break;
            }
        }

        $tok = $this->expect([TokenTypes::Identifier]);

        if ($tok->token !== $node->name) {
            throw new RuntimeException("Closing token tag '{$tok->token}' does not match to open tag {$node->name}.");
        }
        return $node;
    }

    public function parseAttributes(): array
    {
        $attributes = [];
        while (true) {
            $tok = $this->anyOf([TokenTypes::Identifier]);
            if ($tok !== null) {
                $this->expect([TokenTypes::Equal]);
                $attr = $this->expect([TokenTypes::AttributeValue]);
                $attributes[$tok->token] = $attr->token;
            } else {
                break;
            }
        }
        return $attributes;
    }
}
