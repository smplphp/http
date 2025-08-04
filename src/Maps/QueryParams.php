<?php
declare(strict_types=1);

namespace Smpl\Http\Maps;

use Smpl\Http\Concerns\MapsData;
use Smpl\Http\Contracts\QueryMap;

final readonly class QueryParams implements QueryMap
{
    use MapsData;

    /**
     * @param array<string, string|array<string|int, string|object|null>|object|null> $data
     */
    public function __construct(array $data = [])
    {
        $this->setData($data);
    }
}
