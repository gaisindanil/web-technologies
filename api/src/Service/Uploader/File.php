<?php

declare(strict_types=1);

namespace App\Service\Uploader;

final class File
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $name;
    private $size;
    private $extension;
    private $hash;
    private $realName;

    public function __construct(
        string $path,
        string $name,
        int $size,
        string $extension,
        string $realName,
        string $hash = null
    ) {
        $this->path = $path;
        $this->name = $name;
        $this->size = $size;
        $this->extension = $extension;
        $this->hash = $hash;
        $this->realName = $realName;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function getRealName(): string
    {
        return $this->realName;
    }
}
