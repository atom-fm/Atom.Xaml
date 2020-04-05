<?php

namespace Atom\Xaml\Parser;

use RuntimeException;

class Lexer
{
    protected $source;
    protected $current;
    protected $end;
    protected $at;
    protected $line = 0;
    protected $tokens = [];

    public function setSource(string $source): void
    {
        $this->source = $source;
        $this->end = strlen($source);
        $this->current = 0;
        $this->at = 0;
        $this->line = 1;
    }

    public function getTokens(): array
    {
        return $this->tokens;
    }

    public function assign(Lexer $lexer):void
    {
        $this->source = $lexer->source;
        $this->current = $lexer->current;
        $this->end = $lexer->end;
        $this->at = $lexer->at;
        $this->line = $lexer->line;
        $this->tokens = $lexer->tokens;
    }

    public function at(): string
    {
        if ($this->at < $this->end) {
            return $this->source[$this->at];
        }
        return "\0";
    }

    public function seekTo(string $text): bool
    {
        $result = strpos($this->source, $text, $this->at);
        if ($result !== false) {
            $this->advance($result - $this->at);
            return true;
        }
        return false;
    }

    public function text(int $size): string
    {
        return substr($this->source, $this->at, $size);
    }

    public function isEof(): bool
    {
        return $this->at >= $this->end;
    }

    public function advance(int $n): void
    {
        $this->line += substr_count($this->source, "\n", $this->at, $n);
        $this->at += $n;
    }

    public function isAt(string $text): bool
    {
        $sourceText = substr($this->source, $this->current, strlen($text));
        return $sourceText === $text;
    }

    public function takeWhileAnyOf(string $chars): void
    {
        $this->takeWhile(function ($ch) use ($chars) {
            return strpos($chars, $ch) !== false;
        });
    }

    public function takeWhileMatches(string $pattern): void
    {
        $this->takeWhile(function ($ch) use ($pattern) {
            return preg_match($pattern, $ch) === 1;
        });
    }

    public function takeWhile(callable $predicate): void
    {
        while ($this->at < $this->end) {
            $at = $this->source[$this->at];
            if ($predicate($at)) {
                $this->at++;
                continue;
            }
            break;
        }
    }

    public function takeUntil(callable $predicate): void
    {
        while ($this->at < $this->end) {
            $at = $this->source[$this->at];
            if ($predicate($at)) {
                break;
            }
            $this->at++;
        }
    }

    public function ignore(): void
    {
        $this->start = $this->at;
    }

    public function emit($tokenType): Token
    {
        $token = substr($this->source, $this->start, $this->at - $this->start);
        $this->tokens[] = $tok = new Token($token, $tokenType, $this->start, $this->line);
        $this->start = $this->at;
        return $tok;
    }

    public function matches(int $sizeToTest, string $pattern): bool
    {
        $text = $this->text($sizeToTest);
        if (preg_match($pattern, $text) ===1) {
            return true;
        }
        return false;
    }

    public function hasAnyTokens(): bool
    {
        return count($this->tokens) > 0;
    }

    public function getLastToken(): Token
    {
        return $this->tokens[count($this->tokens)-1];
    }

    public function expect(array $tokens, bool $advance = true): string
    {
        foreach ($tokens as $token) {
            $size = strlen($token);
            $text = $this->text($size);
            if ($text === $token) {
                if ($advance) {
                    $this->advance($size);
                }
                return $token;
            }
        }
        $tokenList = implode(", ", $tokens);
        $text = $this->text(10);
        if (count($tokens) == 1) {
            $message = "Expected token '$tokenList' but found '$text'";
        } else {
            $message = "Expected tokens '$tokenList' but found '$text'";
        }

        throw new RuntimeException($message);
    }
}
