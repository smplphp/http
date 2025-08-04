<?php

namespace Smpl\Http\Contracts;

use Override;

/**
 * Input Map
 *
 * Represents a collection of input values, allowing for checking for
 * existence and retrieval of them by their names.
 */
interface InputMap extends DataMap
{
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
    public function file(string $name): ?UploadedFile;
}
