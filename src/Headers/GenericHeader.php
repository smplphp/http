<?php
declare(strict_types=1);

namespace Smpl\Http\Headers;

use Override;
use Smpl\Http\Contracts\Header;

final readonly class GenericHeader implements Header
{
    /**
     * @var lowercase-string
     */
    public string $name;

    public string $value;

    /**
     * @var list<string>
     */
    public array $values;

    /**
     * @param string        $name
     * @param string        $value
     * @param array<string> $values
     */
    public function __construct(string $name, string $value, array $values = [])
    {
        $this->name   = strtolower($name);
        $this->value  = $value;
        $this->values = empty($values) ? [$value] : $values;
    }

    /**
     * Get the header name.
     *
     * Header names are always case-insensitive, though it is recommended to use
     * a normalised format (e.g. "Content-Type" or "content-type") for easier
     * comparison.
     *
     * @return lowercase-string
     */
    #[Override]
    public function name(): string
    {
        return $this->name;
    }

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
    #[Override]
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Get the header value as an array of strings.
     *
     * Some header values may contain multiple values separated by commas; this
     * method should return those values as an array of strings.
     *
     * @return list<string>
     */
    #[Override]
    public function values(): array
    {
        return $this->values;
    }
}
