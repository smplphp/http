<?php
declare(strict_types=1);

namespace Smpl\Http\Headers;

use Closure;
use Smpl\Http\ContentType;

final readonly class ContentTypeHeaderFactory
{
    /**
     * @return \Closure(string): \Smpl\Http\Headers\ContentTypeHeader
     */
    public static function make(): Closure
    {
        return new self()(...);
    }

    public function __invoke(string $value): ContentTypeHeader
    {
        return new ContentTypeHeader(ContentType::from($value));
    }
}
