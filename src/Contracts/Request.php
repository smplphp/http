<?php

namespace Smpl\Http\Contracts;

use Smpl\Http\Enums\HttpProtocol;

/**
 * Request
 *
 * This interface defines the structure for the object-based representation of
 * an HTTP request.
 */
interface Request
{
    /**
     * Get the HTTP request method.
     *
     * @return \Smpl\Http\Contracts\RequestMethod
     */
    public function method(): RequestMethod;

    /**
     * Get the HTTP request target.
     *
     * @return string
     */
    public function target(): string;

    /**
     * Get the request URI.
     *
     * @return \Smpl\Http\Contracts\Uri|null
     */
    public function uri(): ?Uri;

    /**
     * Get the HTTP protocol.
     *
     * @return \Smpl\Http\Enums\HttpProtocol
     */
    public function protocol(): HttpProtocol;

    /**
     * Get the requested host.
     *
     * @return string
     */
    public function host(): string;

    /**
     * Get the request content type.
     *
     * @return \Smpl\Http\Contracts\ContentType|null
     */
    public function contentType(): ?ContentType;

    /**
     * Get the request headers.
     *
     * @return \Smpl\Http\Contracts\HeaderMap
     */
    public function headers(): HeaderMap;

    /**
     * Get the request query parameters.
     *
     * @return \Smpl\Http\Contracts\QueryMap
     */
    public function query(): QueryMap;

    /**
     * Get the request input parameters.
     *
     * This method returns an instance of {@see \Smpl\Http\Contracts\InputMap},
     * which represents a collection of input values as key-value pairs.
     *
     * @return \Smpl\Http\Contracts\InputMap
     */
    public function input(): InputMap;
}
