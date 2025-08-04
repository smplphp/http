<?php

namespace Smpl\Http\Contracts;

interface Header
{
    /**
     * Get the header name.
     *
     * Header names are always case-insensitive, though it is recommended to use
     * a normalised format (e.g. "Content-Type" or "content-type") for easier
     * comparison.
     *
     * @return lowercase-string
     */
    public function name(): string;

    /**
     * Get the header value.
     *
     * Header values are always a string but may contain multiple values
     * separated by commas.
     * This method should return the whole value of the header, as a single
     * string.
     *
     * @return string
     */
    public function value(): string;

    /**
     * Get the header value as an array of strings.
     *
     * Some header values may contain multiple values separated by commas; this
     * method should return those values as an array of strings.
     *
     * @return list<string>
     */
    public function values(): array;
}
