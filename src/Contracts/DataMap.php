<?php

namespace Smpl\Http\Contracts;

use Countable;

/**
 * Data Map
 *
 * Represents a collection of key value pairs, allowing for checking for
 * existence and retrieval of them by their names.
 */
interface DataMap extends Countable
{
    /**
     * Check if a data value exists in the map.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Check if a data value exists in the map and is an array.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasMany(string $name): bool;

    /**
     * Get a data value by its name from the map.
     *
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get(string $name, mixed $default = null): mixed;

    /**
     * Get a data value by its name from the map, expecting it to be an
     * array.
     *
     * This method will return the data value as an <code>array</code> if
     * it exists, or <code>null</code> if it does not.
     * If the data value exists but is not an array, it will return
     * <code>null</code>, or the provided default value if specified.
     *
     * @param string                         $name
     * @param array<string|int, mixed>|null $default
     *
     * @return array<string|int, mixed>|null
     */
    public function array(string $name, ?array $default = null): array|null;

    /**
     * Get a data value by its name from the map, expecting it to be a
     * string.
     *
     * This method will return the data value as a <code>string</code> if
     * it exists, or <code>null</code> if it does not.
     *
     * @param string      $name
     * @param string|null $default
     *
     * @return string|null
     */
    public function string(string $name, ?string $default = null): string|null;

    /**
     * Get a data value by its name from the map, expecting it to be an
     * integer.
     *
     * This method will return the data value as an <code>int</code> if
     * it exists, or <code>null</code> if it does not.
     * If the data value exists but is not an integer, it will return
     * <code>null</code>, or the provided default value if specified.
     *
     * @param string   $name
     * @param int|null $default
     *
     * @return int|null
     */
    public function int(string $name, ?int $default = null): int|null;

    /**
     * Get a data value by its name from the map, expecting it to be a
     * float.
     *
     * This method will return the data value as a <code>float</code> if
     * it exists, and <code>null</code> if it does not.
     * If the data value exists but is not a float, it will return
     * <code>null</code>, or the provided default value if specified.
     *
     * @param string     $name
     * @param float|null $default
     *
     * @return float|null
     */
    public function float(string $name, ?float $default = null): float|null;

    /**
     * Get a data value by its name from the map, expecting it to be a
     * bool.
     *
     * This method will return the data value as a <code>bool</code> if
     * it exists, and <code>null</code> if it does not.
     * If the data value exists but is not a bool, it will return
     * <code>null</code>, or the provided default value if specified.
     *
     * @param string    $name
     * @param bool|null $default
     *
     * @return bool|null
     */
    public function bool(string $name, ?bool $default = null): bool|null;
}
