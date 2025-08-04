<?php
declare(strict_types=1);

namespace Smpl\Http\Headers;

use Override;
use Smpl\Http\Contracts\ContentType;
use Smpl\Http\Contracts\Header;

final readonly class ContentTypeHeader implements Header
{
    /**
     * @var \Smpl\Http\Contracts\ContentType
     */
    private ContentType $contentType;

    public function __construct(ContentType $contentType)
    {
        $this->contentType = $contentType;
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
        return 'content-type';
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
        return (string)$this->contentType;
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
        return [$this->value()];
    }

    /**
     * Get the content type associated with this header.
     *
     * This method returns the content type object that this header represents.
     *
     * @return \Smpl\Http\Contracts\ContentType
     */
    public function type(): ContentType
    {
        return $this->contentType;
    }
}
