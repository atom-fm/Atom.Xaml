<?php

namespace Atom\Xaml\Parser;

use RuntimeException;

class XamlLexer extends Lexer
{
    private $state = States::StartState;
    private $stack;

    private const Identifier = "/[.a-zA-Z]/";

    public function __construct()
    {
        $this->stack = new \SplStack();
    }

    public function skipWs(): self
    {
        $this->takeWhile(function ($ch) {
            if ($ch == "\n") {
                $this->line ++;
            }
            return strpos(" \r\n\t\v\f", $ch) !== false;
        });
        $this->start = $this->at;
        return $this;
    }

    public function readIdentifier(): Token
    {
        $this->skipWs()->takeWhileMatches(self::Identifier);
        return $this->emit(TokenTypes::Identifier);
    }

    public function readOpenTag(): Token
    {
        $this->skipWs()->expect(["<"]);
        return $this->emit(TokenTypes::OpenTag);
    }

    public function readEqaul(): Token
    {
        $this->skipWs()->expect(["="]);
        return $this->emit(TokenTypes::Equal);
    }

    public function readClosingTag(): Token
    {
        $tag = $this->skipWs()->expect(["/>", ">"]);
        return $this->emit($tag == ">" ? TokenTypes::CloseTag : TokenTypes::AutoCloseTag);
    }

    public function readString(): Token
    {
        $token = $this->skipWs()->expect(["\""]);
        $this->takeWhile(function ($ch) use ($token) {
            return $ch !== $token;
        });
        $token = $this->expect([$token]);
        return $this->emit(TokenTypes::AttributeValue);
    }

    public function getNextState()
    {
        $lexer = new self();
        $lexer->assign($this);
        $text = $lexer->skipWs()->text(4);

        if (preg_match("/<\/[A-Z]/", $text) === 1) {
            return States::ComponentEnd;
        }
        if (preg_match("/<[A-Z]/", $text) === 1) {
            return States::ComponentStart;
        }
        if ($text != "") {
            if ($text === "<!--") {
                return States::CommentStart;
            }
            if (strpos($text, "/>") !== false) {
                return States::ClosingTag;
            }
            if ($text[0] === ">") {
                return States::ClosingTag;
            }
        }
        return States::TextStart;
    }

    public function parse(string $source): array
    {
        $this->setSource($source);
        $this->state = States::StartState;

        while (!$this->isEof()) {
            switch ($this->state) {

                // StartState
                case States::StartState: {
                    $this->skipWs();
                    if ($this->matches(2, "/<[A-Z]/")) {
                        $this->state = States::ComponentStart;
                    } else {
                        throw new RuntimeException("Component start expected.");
                    }
                } break;

                // ComponentStart
                case States::ComponentStart: {
                    $this->readOpenTag();
                    $tok = $this->readIdentifier();
                    $this->stack->push($tok->token);

                    while (true) {
                        $next = $this->getNextState();
                        if ($next === States::ClosingTag) {
                            break;
                        } elseif ($next == States::TextStart) {
                            $this->readIdentifier();
                            $this->readEqaul();
                            $this->readString();
                        } else {
                            throw new RuntimeException("Invalid character");
                        }
                    }
                    $tok = $this->readClosingTag();
                    if ($tok->tokenType === TokenTypes::AutoCloseTag) {
                        $this->stack->pop();
                    }
                    $this->state = $this->getNextState();
                } break;

                // TextStart
                case States::TextStart: {
                    $tag = $this->stack->top();
                    $endTag = "</$tag>";
                    if ($this->seekTo($endTag)) {
                        $tok = $this->emit(TokenTypes::Text);
                    } else {
                        throw new RuntimeException("Missing closing tag for $tag component.");
                    }
                    $this->state = States::ComponentEnd;
                } break;

                // ComponentEnd
                case States::ComponentEnd: {
                    $this->skipWs();
                    $this->expect(["</"]);
                    $this->readIdentifier();
                    $this->expect([">"]);
                    $this->ignore();
                    $this->stack->pop();
                    $this->state = $this->getNextState();
                } break;

                // CommentStart
                case States::CommentStart: {
                    $this->skipWs();
                    $this->expect(["<!--"]);
                    if ($this->seekTo("-->")) {
                        $this->advance(3);
                        $this->ignore();
                    } else {
                        throw new RuntimeException("Missing comment closing tag.");
                    }
                    $this->state = $this->getNextState();
                } break;

                default: {
                    $text = $this->text(20);
                    throw new RuntimeException("Unexpected token near $text.");
                } break;
            }
        }
        return $this->tokens;
    }
}
