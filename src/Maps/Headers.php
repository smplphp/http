<?php
declare(strict_types=1);

namespace Smpl\Http\Maps;

use InvalidArgumentException;
use Override;
use Smpl\Http\Contracts\Header;
use Smpl\Http\Contracts\HeaderMap;

final readonly class Headers implements HeaderMap
{
    /**
     * @var array<lowercase-string, \Smpl\Http\Contracts\Header>
     */
    private array $headers;

    /**
     * @param array<\Smpl\Http\Contracts\Header> $headers
     */
    public function __construct(array $headers = [])
    {
        $mappedHeaders = [];

        foreach ($headers as $header) {
            /** @phpstan-ignore-next-line */
            if (! $header instanceof Header) {
                throw new InvalidArgumentException('All items must implement the Header interface.');
            }

            $mappedHeaders[$header->name()] = $header;
        }

        $this->headers = $mappedHeaders;
    }

    /**
     * Check if a header exists in the map.
     *
     * @param string $name
     *
     * @return bool
     */
    #[Override]
    public function has(string $name): bool
    {
        // Check if the header exists in the map
        return isset($this->headers[strtolower($name)]);
    }

    /**
     * Get a header by its name from the map.
     *
     * @param string $name
     *
     * @return \Smpl\Http\Contracts\Header|null
     */
    #[Override]
    public function get(string $name): ?Header
    {
        // Return the header if it exists, otherwise return null
        return $this->headers[strtolower($name)] ?? null;
    }
}
