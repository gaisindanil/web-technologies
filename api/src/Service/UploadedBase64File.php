<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UploadedBase64File extends UploadedFile
{
    public function __construct(string $base64String, string $originalName)
    {
        $filePath = tempnam(sys_get_temp_dir(), 'UploadedFile');
        $data = base64_decode($base64String, true);
        $f = finfo_open();

        $mime_type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);

        $ext = explode('/', $mime_type);

        file_put_contents($filePath, $data);
        parent::__construct($filePath, $originalName . '.' . $ext[1], $mime_type);
    }
}
