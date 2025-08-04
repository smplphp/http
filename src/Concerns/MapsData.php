<?php
declare(strict_types=1);

namespace Smpl\Http\Concerns;

/**
 * @phpstan-require-implements \Smpl\Http\Contracts\DataMap
 * @psalm-require-implements \Smpl\Http\Contracts\DataMap
 */
trait MapsData
{
    /**
     * Values that are considered truthy.
     *
     * @var array<string, non-empty-string>
     */
    private static array $truthyValues = [
        'true',
        '1',
        'yes',
        'on',
    ];

    /**
     * Values that are considered falsy.
     *
     * @var array<string, non-empty-string>
     */
    private static array $falsyValues = [
        'false',
        '0',
        'no',
        'off',
    ];

    /**
     * Set the truthy and falsy values used for boolean conversion.
     *
     * This method allows you to set custom truthy and falsy values that will
     * be used when converting string data to boolean.
     *
     * @param array<string, non-empty-string>|null $truthy Values that are considered truthy.
     * @param array<string, non-empty-string>|null $falsy  Values that are considered falsy.
     *
     * @return void
     */
    public static function setBooleanValues(?array $truthy = null, ?array $falsy = null): void
    {
        if ($truthy !== null) {
            self::$truthyValues = $truthy;
        }

        if ($falsy !== null) {
            self::$falsyValues = $falsy;
        }
    }

    /**
     * @var array<string, mixed>
     */
    private array $data = [];

    /**
     * @param array<string, mixed> $data
     *
     * @return void
     */
    protected function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * Check if a data value exists in the map.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        // We're using array_key_exists to check if the key exists in the
        // array, which is more reliable than isset() for checking keys that
        // may have a value of null.
        return array_key_exists($name, $this->data);
    }

    /**
     * Check if a data value exists in the map and is an array.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasMany(string $name): bool
    {
        return $this->has($name) && is_array($this->data[$name]);
    }

    /**
     * Get a data value by its name from the map.
     *
     * @param string                                $name
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $name, mixed $default = null): mixed
    {
        return $this->data[$name] ?? $default;
    }

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
    public function array(string $name, ?array $default = null): array|null
    {
        $value = $this->get($name);

        if (is_array($value)) {
            return $value;
        }

        return $default;
    }

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
    public function string(string $name, ?string $default = null): string|null
    {
        $value = $this->get($name);

        if (is_string($value)) {
            return $value;
        }

        return $default;
    }

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
    public function int(string $name, ?int $default = null): int|null
    {
        $value = $this->get($name);

        if (is_numeric($value)) {
            return (int)$value;
        }

        return $default;
    }

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
    public function float(string $name, ?float $default = null): float|null
    {
        $value = $this->get($name);

        if (is_numeric($value)) {
            return (float)$value;
        }

        return $default;
    }

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
    public function bool(string $name, ?bool $default = null): bool|null
    {
        $value = $this->get($name);

        if (is_string($value)) {
            // Normalise the string and trim it of any extra whitespace.
            $value = strtolower(trim($value));

            // Is it a truthy value?
            if (in_array($value, self::$truthyValues, true)) {
                return true;
            }

            // Is it a falsy value?
            if (in_array($value, self::$falsyValues, true)) {
                return false;
            }
        }

        return $default;
    }

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int<0,max> The custom count as an integer.
     * <p>
     * The return value is cast to an integer.
     * </p>
     */
    public function count(): int
    {
        return count($this->data);
    }
}
