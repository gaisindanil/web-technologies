<?php

declare(strict_types=1);

namespace App\Domain\Auth\Command\JoinProfile\Request;

final class Command
{
    public int $userId;

    public string $title = '';

    public ?string $contactPerson = null;

    public ?string $contactPhone = null;

    public string $ogrn = '';

    public string $inn = '';

    public string $kpp = '';

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}
