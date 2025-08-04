<?php
declare(strict_types=1);

namespace Smpl\Http;

use Override;

final readonly class ContentType implements Contracts\ContentType
{
    /**
     * Create a new ContentType instance from a string representation.
     *
     * @param string $contentType
     *
     * @return self
     */
    public static function from(string $contentType): self
    {
        $parts = array_map('trim', explode(';', $contentType));
        [$type, $subtype] = explode('/', strtolower(array_shift($parts)));

        $pos = strpos($subtype, '+');

        if ($pos !== false) {
            $suffix  = substr($subtype, $pos + 1);
            $subtype = substr($subtype, 0, $pos);
        } else {
            $suffix = null;
        }

        $parameters = [];

        foreach ($parts as $part) {
            $pos  = strpos($part, '=');

            if ($pos !== false) {
                $parameters[substr($part, 0, $pos)] = substr($part, $pos + 1);
            }
        }

        return new self($type, $subtype, $suffix, $parameters);
    }

    private string $type;

    private string $subtype;

    private ?string $suffix;

    /**
     * @var array<string, string>
     */
    private array $parameters;

    /**
     * @param string                $type
     * @param string                $subtype
     * @param string|null           $suffix
     * @param array<string, string> $parameters
     */
    public function __construct(string $type, string $subtype, ?string $suffix = null, array $parameters = [])
    {
        $this->type       = $type;
        $this->subtype    = $subtype;
        $this->suffix     = $suffix;
        $this->parameters = $parameters;
    }

    /**
     * Get the primary type of the content type.
     *
     * @return string
     */
    #[Override]
    public function type(): string
    {
        return $this->type;
    }

    /**
     * Get the subtype of the content type.
     *
     * @return string
     */
    #[Override]
    public function subtype(): string
    {
        return $this->subtype;
    }

    /**
     * Get the optional suffix of the content type.
     *
     * @return string|null
     */
    #[Override]
    public function suffix(): ?string
    {
        return $this->suffix;
    }

    /**
     * Get the parameters supplied with the content type.
     *
     * @return array<string, string>
     */
    #[Override]
    public function parameters(): array
    {
        return $this->parameters;
    }

    /**
     * Magic method {@see https://www.php.net/manual/en/language.oop5.magic.php#object.tostring}
     * allows a class to decide how it will react when it is treated like a string.
     *
     * @return string Returns string representation of the object that
     * implements this interface (and/or "__toString" magic method).
     */
    public function __toString(): string
    {
        $type = $this->type . '/' . $this->subtype;

        if ($this->suffix !== null) {
            $type .= '+' . $this->suffix;
        }

        if (! empty($this->parameters)) {
            $params = [];
            foreach ($this->parameters as $key => $value) {
                $params[] = $key . '=' . $value;
            }
            $type .= '; ' . implode('; ', $params);
        }

        return $type;
    }
}
