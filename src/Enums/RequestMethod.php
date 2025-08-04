<?php
declare(strict_types=1);

namespace Smpl\Http\Enums;

use Override;
use Smpl\Http\Contracts\RequestMethod as Contract;

/**
 * HTTP Methods
 *
 * This enum defines the standard HTTP methods used in web communication.
 *
 * @psalm-pure
 * @phpstan-pure
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Methods
 */
enum RequestMethod: string implements Contract
{
    /**
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Methods/GET
     */
    case GET = 'GET';

    /**
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Methods/POST
     */
    case POST = 'POST';

    /**
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Methods/PUT
     */
    case PUT = 'PUT';

    /**
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Methods/PATCH
     */
    case PATCH = 'PATCH';

    /**
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Methods/DELETE
     */
    case DELETE = 'DELETE';

    /**
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Methods/HEAD
     */
    case HEAD = 'HEAD';

    /**
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Methods/OPTIONS
     */
    case OPTIONS = 'OPTIONS';

    /**
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Methods/TRACE
     */
    case TRACE = 'TRACE';

    /**
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Methods/CONNECT
     */
    case CONNECT = 'CONNECT';

    /**
     * Get the HTTP method name.
     *
     * The method name is the verb that appears in the HTTP request, such as
     * 'GET', 'POST', etc.
     *
     * @return string
     */
    #[Override]
    public function name(): string
    {
        return $this->value;
    }

    /**
     * Should the HTTP method have a request body?
     *
     * Some HTTP methods, like POST, PUT, and PATCH, typically expect a
     * request body containing data to be sent to the server, whereas others
     * shouldn't ever have a request body.
     *
     * @return bool
     */
    #[Override]
    public function shouldHaveRequestBody(): bool
    {
        return match ($this) {
            self::POST, self::PUT, self::PATCH, self::DELETE => true,
            default                                          => false,
        };
    }

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
    #[Override]
    public function shouldHaveResponseBody(bool $success = true): bool
    {
        return match ($this) {
            self::GET, self::POST, self::PUT, self::PATCH, self::DELETE => true,
            self::HEAD, self::OPTIONS, self::TRACE, self::CONNECT       => false,
        };
    }

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
    #[Override]
    public function isSafe(): bool
    {
        return match ($this) {
            self::GET, self::HEAD, self::OPTIONS, self::TRACE => true,
            default                                           => false,
        };
    }

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
    #[Override]
    public function isIdempotent(): bool
    {
        return match ($this) {
            self::GET, self::PUT, self::DELETE, self::HEAD, self::OPTIONS, self::TRACE => true,
            self::POST, self::PATCH, self::CONNECT                                     => false,
        };
    }

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
    #[Override]
    public function isCacheable(): bool
    {
        return match ($this) {
            self::GET, self::HEAD, self::POST, self::PATCH => true,
            default                                        => false,
        };
    }
}
