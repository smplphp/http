<?php
declare(strict_types=1);

namespace Smpl\Http\Factories;

use Closure;
use Smpl\Http\Contracts\Header;
use Smpl\Http\Contracts\HeaderMap;
use Smpl\Http\Headers\GenericHeader;
use Smpl\Http\Maps\Headers;

final class HeaderFactory
{
    /**
     * @var array<lowercase-string, \Closure(string): \Smpl\Http\Contracts\Header>
     */
    private array $customHeaders = [];

    /**
     * Register a custom header creator.
     *
     * @param string                                        $name
     * @param \Closure(string): \Smpl\Http\Contracts\Header $creator
     *
     * @return self
     */
    public function register(string $name, Closure $creator): self
    {
        $this->customHeaders[strtolower($name)] = $creator;

        return $this;
    }

    /**
     * Create a header instance.
     *
     * @param string             $name   The name of the header.
     * @param string             $value  The value of the header.
     * @param array<string>|null $values The values of the header, if applicable.
     *
     * @return \Smpl\Http\Contracts\Header
     */
    public function make(string $name, string $value, ?array $values = null): Header
    {
        $name = strtolower($name);

        if (isset($this->customHeaders[$name])) {
            return ($this->customHeaders[$name])($value);
        }

        if ($values === null) {
            $values = explode(',', $value);
        }

        return new GenericHeader($name, $value, $values);
    }

    /**
     * Create multiple header instances from an associative array.
     *
     * @param array<string, string|array<string>> $headers
     *
     * @return array<string, \Smpl\Http\Contracts\Header>
     */
    public function makeMany(array $headers): array
    {
        $instances = [];

        foreach ($headers as $name => $value) {
            if (is_array($value)) {
                $values = $value;
                $value  = implode(',', $value);
            }

            $instances[strtolower($name)] = $this->make($name, $value, $values ?? null);
        }

        return $instances;
    }

    /**
     * Create multiple header instances from the superglobal values.
     *
     * @param array<string, string> $globals
     *
     * @return array<string, \Smpl\Http\Contracts\Header>
     */
    public function makeManyFromGlobals(array $globals): array
    {
        $headers = [];

        foreach ($globals as $name => $value) {
            if (str_starts_with($name, 'HTTP_')) {
                $headerName = substr($name, 5);
            } else if (str_starts_with($name, 'CONTENT_')) {
                $headerName = substr($name, 8);
            } else {
                continue;
            }

            $headerName = strtolower(str_replace('_', '-', $headerName));

            $headers[$headerName] = $this->make($headerName, $value);
        }

        return $headers;
    }

    /**
     * Create multiple headers within a header map.
     *
     * @param array<string, string> $headers
     * @param bool                  $globals
     *
     * @return \Smpl\Http\Contracts\HeaderMap
     */
    public function map(array $headers, bool $globals = false): HeaderMap
    {
        return new Headers($globals ? $this->makeManyFromGlobals($headers) : $this->makeMany($headers));
    }
}
