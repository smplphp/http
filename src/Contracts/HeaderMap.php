<?php

namespace Smpl\Http\Contracts;

/**
 * Header Map
 *
 * Represents a collection of HTTP headers, allowing for checking for existence
 * and retrieval of them by their names.
 */
interface HeaderMap
{
    /**
     * Check if a header exists in the map.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Get a header by its name from the map.
     *
     * @param string $name
     *
     * @return \Smpl\Http\Contracts\Header|null
     */
    public function get(string $name): ?Header;
}
