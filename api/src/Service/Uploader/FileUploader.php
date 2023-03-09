<?php

declare(strict_types=1);

namespace App\Service\Uploader;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class FileUploader
{
    private Filesystem $storage;

    private string $baseUrl;

    private string $rootDirectory;

    public function __construct(
        Filesystem $storage,
        string $baseUrl,
        string $rootDirectory
    ) {
        $this->storage = $storage;
        $this->baseUrl = $baseUrl;
        $this->rootDirectory = $rootDirectory;
    }

    /**
     * @throws FilesystemException
     */
    public function upload(UploadedFile $file): File
    {
        $path = $this->rootDirectory . date('Y/m/d');
        $name = Uuid::uuid4()->toString() . '.' . $file->getClientOriginalExtension();

        $this->storage->createDirectory($path);

        $stream = fopen($file->getRealPath(), 'rb+');

        $this->storage->writeStream($path . '/' . $name, $stream);
        fclose($stream);

        $url = $this->generateUrl($path) . '/' . $name;

        return new File($path, $name, $file->getSize(), $file->getClientOriginalExtension(), $file->getClientOriginalName(), $url);
    }

    public function generateUrl(string $path): string
    {
        return $this->baseUrl . '/' . $path;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
