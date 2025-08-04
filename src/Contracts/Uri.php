<?php

namespace Smpl\Http\Contracts;

use Stringable;

/**
 * URI
 *
 * This interface defines the structure for the object-based representation of
 * a URI.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/URI
 *
 * @phpstan-type UriComponents array{
 *     scheme: string|null,
 *     authority: string|null,
 *     userInfo: string|null,
 *     host: string|null,
 *     port: int|null,
 *     path: string,
 *     query: string|null,
 *     fragment: string|null,
 *     user?: string|null,
 *     pass?: string|null,
 * }
 */
interface Uri extends Stringable
{
    /**
     * Get the URI scheme.
     *
     * @return string|null
     */
    public function scheme(): ?string;

    /**
     * Get the URI authority.
     *
     * @return string|null
     */
    public function authority(): ?string;

    /**
     * Get the URI user info.
     *
     * @return string|null
     */
    public function userInfo(): ?string;

    /**
     * Get the URI host.
     *
     * @return string|null
     */
    public function host(): ?string;

    /**
     * Get the URI port.
     *
     * @return int|null
     */
    public function port(): ?int;

    /**
     * Get the URI path.
     *
     * @return string
     */
    public function path(): string;

    /**
     * Get the URI query string.
     *
     * @return string|null
     */
    public function query(): ?string;

    /**
     * Get the URI fragment.
     *
     * @return string|null
     */
    public function fragment(): ?string;

    /**
     * Get the components of the URI.
     *
     * @return array<string, string|int|null>
     *
     * @phpstan-return UriComponents
     */
    public function components(): array;
}
