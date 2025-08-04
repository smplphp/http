<?php
declare(strict_types=1);

namespace Smpl\Http\Enums;

/**
 * HTTP Version
 *
 * This enum represents the different versions of the HTTP protocol.
 */
enum HttpProtocol: string
{
    case HTTP_1_0 = 'HTTP/1.0';

    case HTTP_1_1 = 'HTTP/1.1';

    case HTTP_2_0 = 'HTTP/2.0';

    case HTTP_3_0 = 'HTTP/3.0';
}
