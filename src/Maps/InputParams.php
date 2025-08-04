<?php
declare(strict_types=1);

namespace Smpl\Http\Maps;

use Override;
use Smpl\Http\Concerns\MapsData;
use Smpl\Http\Contracts\InputMap;
use Smpl\Http\Contracts\UploadedFile;

final readonly class InputParams implements InputMap
{
    use MapsData;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        $this->setData($data);
    }

    /**
     * Get a file by its name from the map.
     *
     * This method is specifically for retrieving uploaded files.
     * It returns an instance of {@see \Smpl\Http\Contracts\UploadedFile} if the
     * file exists, or <code>null</code> if it does not.
     *
     * @param string $name
     *
     * @return \Smpl\Http\Contracts\UploadedFile|null
     */
    #[Override]
    public function file(string $name): ?UploadedFile
    {
        /** @psalm-suppress MixedAssignment */
        $data = $this->get($name);

        if ($data instanceof UploadedFile) {
            return $data;
        }

        return null;
    }
}
