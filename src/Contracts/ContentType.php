<?php

namespace Smpl\Http\Contracts;

use Stringable;

/**
 * Content Type
 *
 * Represents a content type, which is a media type used in HTTP Content-Type
 * header.
 * It has the same composite parts as a standard MIME type, but it may also
 * have additional parameters.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers/Content-Type
 * @link https://developer.mozilla.org/en-US/docs/Glossary/MIME_type
 */
interface ContentType extends Stringable
{
    /**
     * Get the primary type of the content type.
     *
     * @return string
     */
    public function type(): string;

    /**
     * Get the subtype of the content type.
     *
     * @return string
     */
    public function subtype(): string;

    /**
     * Get the optional suffix of the content type.
     *
     * @return string|null
     */
    public function suffix(): ?string;

    /**
     * Get the parameters supplied with the content type.
     *
     * @return array<string, string>
     */
    public function parameters(): array;
}
