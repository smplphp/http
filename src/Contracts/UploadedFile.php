<?php

namespace Smpl\Http\Contracts;

/**
 * Uploaded File
 *
 * Represents an uploaded file in an HTTP request.
 */
interface UploadedFile
{
    /**
     * Get the name of the file on the client machine.
     *
     * @return string
     */
    public function originalName(): string;

    /**
     * Get the mime type of the uploaded file.
     *
     * @return string|null
     */
    public function mimeType(): ?string;

    /**
     * Get the size of the uploaded file in bytes.
     *
     * @return int
     */
    public function size(): int;

    /**
     * Check if the uploaded file is valid.
     *
     * @return bool
     */
    public function isValid(): bool;

    /**
     * Get the error code associated with the uploaded file.
     *
     * @return int
     */
    public function error(): int;

    /**
     * Get the temporary path of the uploaded file.
     *
     * @return string
     */
    public function path(): string;
}
