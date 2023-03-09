<?php

declare(strict_types=1);

namespace App\Domain\Auth\Command\JoinProfile\Edit;

final class Command
{
    public int $userId;

    public int $profileId;

    public string $title = '';

    public ?string $contactPerson = null;

    public ?string $contactPhone = null;

    public string $ogrn = '';

    public string $inn = '';

    public string $kpp = '';

    public function __construct(
        int $userId,
        int $profileId,
        string $title,
        ?string $contactPerson,
        ?string $contactPhone,
        string $ogrn,
        string $inn,
        string $kpp
    ) {
        $this->userId = $userId;
        $this->profileId = $profileId;
        $this->title = $title;
        $this->contactPerson = $contactPerson;
        $this->contactPhone = $contactPhone;
        $this->ogrn = $ogrn;
        $this->inn = $inn;
        $this->kpp = $kpp;
    }
}
