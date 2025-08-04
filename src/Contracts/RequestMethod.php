<?php

namespace Smpl\Http\Contracts;

/**
 * Request Method
 *
 * This interface defines the contract for HTTP request methods, which are the
 * verbs used in HTTP requests to indicate the desired action to be performed on
 * a resource.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Methods
 */
interface RequestMethod
{
    /**
     * Get the HTTP method name.
     *
     * The method name is the verb that appears in the HTTP request, such as
     * 'GET', 'POST', etc.
     *
     * @return string
     */
    public function name(): string;

    /**
     * Should the HTTP method have a request body?
     *
     * Some HTTP methods, like POST, PUT, and PATCH, typically expect a
     * request body containing data to be sent to the server, whereas others
     * shouldn't ever have a request body.
     *
     * @return bool
     */
    public function shouldHaveRequestBody(): bool;

    /**
     * Should the HTTP method have a response body?
     *
     * Some HTTP methods, like HEAD, do not return a response body,
     * whereas others may return a body on success, but not on failure.
     *
     * @param bool $success
     *
     * @return bool
     */
    public function shouldHaveResponseBody(bool $success = true): bool;

    /**
     * Is the HTTP method safe?
     *
     * Safe HTTP methods are those that do not modify the state of the server.
     * All safe methods should also be idempotenant, but not all idempotent
     * methods are safe.
     *
     * @return bool
     *
     * @link https://developer.mozilla.org/en-US/docs/Glossary/Safe/HTTP
     */
    public function isSafe(): bool;

    /**
     * Is the HTTP method idempotent?
     *
     * Idempotent HTTP methods are those where multiple identical requests
     * have the same effect as a single request.
     *
     * @return bool
     *
     * @link https://developer.mozilla.org/en-US/docs/Glossary/Idempotent
     */
    public function isIdempotent(): bool;

    /**
     * Is the HTTP method cacheable?
     *
     * Cacheable HTTP methods are those marked as being safe to be cached.
     * The cacheable state of the chosen HTTP method will typically be used to
     * determine whether the response can be cached, along with other
     * factors.
     *
     * @return bool
     *
     * @link https://developer.mozilla.org/en-US/docs/Glossary/Cacheable
     */
    public function isCacheable(): bool;
}
