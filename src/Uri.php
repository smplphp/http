<?php
declare(strict_types=1);

namespace Smpl\Http;

use Override;

/**
 * @phpstan-import-type UriComponents from \Smpl\Http\Contracts\Uri
 */
final readonly class Uri implements Contracts\Uri
{
    /**
     * @param array<string, string|int|null> $components
     * @param string                         $uri
     *
     * @phpstan-param UriComponents          $components
     *
     * @return self
     */
    public static function from(array $components, string $uri): self
    {
        $normalisedUri = '';

        /** @psalm-suppress RiskyTruthyFalsyComparison */
        if ($components['scheme']) {
            $normalisedUri .= strtolower($components['scheme']) . ':';
        }

        /** @psalm-suppress RiskyTruthyFalsyComparison */
        if ($components['authority']) {
            $normalisedUri .= '//' . $components['authority'];
        }

        if ($components['path']) {
            $normalisedUri .= $components['path'];
        }

        if ($components['query'] !== null) {
            $normalisedUri .= '?' . $components['query'];
        }

        if ($components['fragment'] !== null) {
            $normalisedUri .= '#' . $components['fragment'];
        }

        return new self($uri, $normalisedUri, $components);
    }

    /**
     * @var string
     *
     * @psalm-suppress PossiblyUnusedProperty
     */
    public string $original;

    public string $uri;

    /**
     * @var array<string, string|int|null>
     * @phpstan-var UriComponents
     */
    private array $components;

    /**
     * @param string                         $original   The original URI string.
     * @param string                         $uri        The URI string.
     * @param array<string, string|int|null> $components Optional components of the URI.
     *
     * @phpstan-param UriComponents          $components
     */
    public function __construct(string $original, string $uri, array $components)
    {
        $this->original   = $original;
        $this->components = $components;
        $this->uri        = $uri;
    }

    /**
     * Magic method {@see https://www.php.net/manual/en/language.oop5.magic.php#object.tostring}
     * allows a class to decide how it will react when it is treated like a string.
     *
     * @return string Returns string representation of the object that
     * implements this interface (and/or "__toString" magic method).
     */
    #[Override]
    public function __toString(): string
    {
        return $this->uri;
    }

    /**
     * Get the URI scheme.
     *
     * @return string|null
     */
    #[Override]
    public function scheme(): ?string
    {
        return $this->components['scheme'];
    }

    /**
     * Get the URI authority.
     *
     * @return string|null
     */
    #[Override]
    public function authority(): ?string
    {
        return $this->components['authority'];
    }

    /**
     * Get the URI user info.
     *
     * @return string|null
     */
    #[Override]
    public function userInfo(): ?string
    {
        return $this->components['userInfo'];
    }

    /**
     * Get the URI host.
     *
     * @return string|null
     */
    #[Override]
    public function host(): ?string
    {
        return $this->components['host'];
    }

    /**
     * Get the URI port.
     *
     * @return int|null
     */
    #[Override]
    public function port(): ?int
    {
        return $this->components['port'];
    }

    /**
     * Get the URI path.
     *
     * @return string
     */
    #[Override]
    public function path(): string
    {
        return $this->components['path'];
    }

    /**
     * Get the URI query string.
     *
     * @return string|null
     */
    #[Override]
    public function query(): ?string
    {
        return $this->components['query'];
    }

    /**
     * Get the URI fragment.
     *
     * @return string|null
     */
    #[Override]
    public function fragment(): ?string
    {
        return $this->components['fragment'];
    }

    /**
     * Get the components of the URI.
     *
     * @return array<string, string|int|null>
     *
     * @phpstan-return UriComponents
     */
    #[Override]
    public function components(): array
    {
        return $this->components;
    }
}
