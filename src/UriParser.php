<?php
declare(strict_types=1);

namespace Smpl\Http;

use InvalidArgumentException;

/**
 * URI Parser
 *
 * This is an RFC 3986 compliant URI parser that can parse URIs into their
 * components.
 *
 * @phpstan-import-type UriComponents from \Smpl\Http\Contracts\Uri
 */
final class UriParser
{
    public readonly string $uri;

    public readonly int $length;

    /**
     * @var array<string, string|int|null>
     *
     * @phpstan-var UriComponents
     */
    private array $components;

    private int $position = 0;

    public function __construct(string $uri)
    {
        $this->uri    = $uri;
        $this->length = strlen($uri);
    }

    private function isAlpha(?string $char): bool
    {
        return $char !== null && ctype_alpha($char);
    }

    private function isDigit(?string $char): bool
    {
        return $char !== null && ctype_digit($char);
    }

    private function reset(): void
    {
        $this->position   = 0;
        $this->components = [
            'scheme'    => null,
            'authority' => null,
            'userInfo'  => null,
            'host'      => null,
            'port'      => null,
            'user'      => null,
            'pass'      => null,
            'path'      => '',
            'query'     => null,
            'fragment'  => null,
        ];
    }

    private function current(): string
    {
        return $this->uri[$this->position];
    }

    private function next(): ?string
    {
        if ($this->position === ($this->length - 1)) {
            return null;
        }

        return $this->uri[++$this->position];
    }

    private function skip(int $steps = 1): void
    {
        $this->position += abs($steps);
    }

    private function peek(int $steps = 1): ?string
    {
        if ($this->position === ($this->length - 1)) {
            return null;
        }

        return $this->uri[$this->position + abs($steps)];
    }

    private function grab(int $steps = 2): ?string
    {
        $str   = $this->current();
        $steps = max(0, abs($steps) - 1);

        for ($i = 0; $i < $steps; $i++) {
            $char = $this->peek($i);

            if ($char === null) {
                return null;
            }

            $str .= $char;
        }

        return $str;
    }

    /**
     * @return array<string, string|int|null>
     *
     * @phpstan-return UriComponents
     */
    public function parse(): array
    {
        $this->reset();

        if ($this->isAlpha($this->current())) {
            $this->parseScheme();
        }

        if ($this->grab() === '//') {
            $this->parseAuthority();
        }

        if ($this->components['authority'] === null || $this->peek() === '/') {
            $this->parsePath();
        }

        if ($this->peek() === '?') {
            $this->parseQuery();
        }

        if ($this->peek() === '#') {
            $this->parseFragment();
        }

        return $this->components;
    }

    private function parseScheme(): void
    {
        // The first character must be an alpha character, so we'll just
        // grab that.
        $scheme = $this->next();

        if ($scheme === null || ! $this->isAlpha($scheme)) {
            throw new InvalidArgumentException("Invalid scheme character: {$scheme}");
        }

        if ($this->peek() === ':' && $this->peek(2) === '/' && $this->isAlpha($this->peek(3))) {
            // This is a Windows drive letter, e.g. "C:/".
            $this->components['scheme'] = null;

            return;
        }

        while ($this->peek() !== ':') {
            $next = $this->next();

            if (
                $next === null
                || (
                    ! $this->isAlpha($next)
                    && ! $this->isDigit($next)
                    && ! in_array($next, ['+', '-', '.'], true)
                )
            ) {
                // If we've reached the end of the URI, or the next character isn't
                // alphanumeric, a plus, minus, or dot, then we have an invalid
                // scheme.
                throw new InvalidArgumentException("Invalid scheme character: {$next}");
            }

            $scheme .= $next;
        }

        // Set the component to a normalised lowercase version of the scheme.
        $this->components['scheme'] = strtolower($scheme);

        // Skip the colon.
        $this->skip();
    }

    private function parseAuthority(): void
    {
        $authority = '';
        $userInfo  = null;
        $host      = null;
        $port      = null;
        $user      = null;
        $pass      = null;

        // The authority is everything up to the next '/', '?', or '#'.
        while (! in_array($this->peek(), ['/', '?', '#'], true)) {
            $next = $this->next();

            if ($next === null) {
                break;
            }

            $authority .= $next;
        }

        if (empty($authority)) {
            throw new InvalidArgumentException("Invalid URI: {$this->uri}");
        }

        // If it contains an '@', it contains user info, so we'll pull that out.
        if (str_contains($authority, '@')) {
            $atPos = strrpos($authority, '@');

            if ($atPos === false) {
                throw new InvalidArgumentException("Invalid authority: {$authority}");
            }

            $userInfo = substr($authority, 0, $atPos);
        } else {
            $atPos = 1;
        }

        $inIp = false;

        // Start looking through the remainder of the authority for a host
        // and port.
        for ($i = $atPos, $iMax = strlen($authority); $i < $iMax; $i++) {
            // Sometimes hosts are contained within square brackets, such as
            // in IPv6 addresses, so we have to allow for that.
            if ($authority[$i] === '[') {
                $inIp = true;
            } else if ($authority[$i] === ']') {
                $inIp = false;
            }

            if ($inIp === false && $authority[$i] === ':') {
                $host         = substr($authority, $atPos, $i - $atPos);
                $possiblePort = substr($authority, $i + 1);

                if (! is_numeric($possiblePort)) {
                    throw new InvalidArgumentException("Invalid port number: {$possiblePort}");
                }

                $port = (int)$possiblePort;

                break;
            }
        }

        // If we found no port, then the host is everything after the '@'.
        if ($port === null) {
            $host = substr($authority, $atPos);
        }

        // If the user info has been set and contains a colon, then we can
        // split it into a user and password.
        if ($userInfo !== null && str_contains($userInfo, ':')) {
            // Make sure there's only one colon in the user info, and that it's
            // not at the start or end of the string.
            if (substr_count($userInfo, ':') !== 1 || str_ends_with($userInfo, ':') || str_starts_with($userInfo, ':')) {
                throw new InvalidArgumentException("Invalid user info: {$userInfo}");
            }

            /**
             * If this isn't here, static analysis will complain that $pass
             * may be an undefined key, though we're confident that it will
             * be.
             *
             * @var array{string, string} $parts
             */
            $parts = explode(':', $userInfo, 2);
            [$user, $pass] = $parts;
        }

        $this->components['authority'] = $authority;
        $this->components['host']      = $host;
        $this->components['port']      = $port;
        $this->components['userInfo']  = $userInfo;
        $this->components['user']      = $user;
        $this->components['pass']      = $pass;
    }

    private function parsePath(): void
    {
        $path = '';

        // If the next character is a question mark or hash, then we can just
        // set the path as it is.
        if ($this->peek() === '?' || $this->peek() === '#') {
            $this->components['path'] = $path;

            return;
        }

        // The path is everything up to the next '?', or '#'.
        while (! in_array($this->peek(), ['?', '#'], true)) {
            $next = $this->next();

            if ($next === null) {
                break;
            }

            $path .= $next;
        }

        $this->components['path'] = $path;
    }

    private function parseQuery(): void
    {
        // Skip the question mark.
        $this->skip();

        $query = '';

        // The query is everything up to the next '#'.
        while ($this->peek() !== '#') {
            $next = $this->next();

            if ($next === null) {
                break;
            }

            $query .= $next;
        }

        $this->components['query'] = $query;
    }

    private function parseFragment(): void
    {
        // Skip the hash character.
        $this->skip();

        $fragment = '';

        // The fragment is everything after the '#'.
        while ($this->peek() !== null) {
            $next = $this->next();

            if ($next === null) {
                break;
            }

            $fragment .= $next;
        }

        $this->components['fragment'] = $fragment;
    }
}
