<?php
declare(strict_types=1);

namespace Smpl\Http;

use Override;
use Smpl\Http\Contracts\ContentType;
use Smpl\Http\Contracts\RequestMethod;
use Smpl\Http\Enums\HttpProtocol;

/**
 * @psalm-pure
 * @phpstan-pure
 */
final readonly class Request implements Contracts\Request
{
    public RequestMethod $method;

    public string $target;

    public string $host;

    public ?Contracts\Uri $uri;

    public HttpProtocol $version;

    public ?ContentType $contentType;

    public function __construct(
        RequestMethod  $method,
        string         $target,
        string         $host,
        ?Contracts\Uri $uri = null,
        HttpProtocol   $version = HttpProtocol::HTTP_1_1,
        ?ContentType   $contentType = null
    )
    {
        $this->method      = $method;
        $this->target      = $target;
        $this->host        = $host;
        $this->uri         = $uri;
        $this->version     = $version;
        $this->contentType = $contentType;
    }

    /**
     * Get the HTTP request method.
     *
     * @return \Smpl\Http\Contracts\RequestMethod
     */
    #[Override]
    public function method(): RequestMethod
    {
        return $this->method;
    }

    /**
     * Get the requested URI.
     *
     * @return string
     */
    #[Override]
    public function target(): string
    {
        return $this->target;
    }

    /**
     * Get the request URI.
     *
     * @return \Smpl\Http\Contracts\Uri|null
     */
    #[Override]
    public function uri(): ?Contracts\Uri
    {
        return $this->uri;
    }

    /**
     * Get the request HTTP version.
     *
     * @return \Smpl\Http\Enums\HttpProtocol
     */
    #[Override]
    public function protocol(): HttpProtocol
    {
        return $this->version;
    }

    /**
     * Get the requested host.
     *
     * @return string
     */
    #[Override]
    public function host(): string
    {
        return $this->host;
    }

    /**
     * Get the request content type.
     *
     * @return \Smpl\Http\Contracts\ContentType|null
     */
    #[Override]
    public function contentType(): ?ContentType
    {
        return $this->contentType;
    }
}
