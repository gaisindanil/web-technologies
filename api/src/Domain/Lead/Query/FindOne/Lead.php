<?php

declare(strict_types=1);

namespace App\Domain\Lead\Query\FindOne;

final class Lead
{
    public int $id;

    public string $guid;

    public string $createdAt;
    public string $locationId;
    public string $locationLabel;
    public string $personEmail;
    public string $personFullName;
    public string $personInn;
    public string $personPhoneNumber;
    public string $personSeries;
    public string $personNumber;
    public string $personDate;
    public string $personCode;
    public string $personOrgInn;
    public string $personOrgTitle;
    public string $personSnilsNumber;

    public string $personPassportFile;

    public string $personSnilsFile;

    public ?string $personInnFile;

    public function __construct(
        int $id,
        string $guid,
        string $createdAt,
        string $locationId,
        string $locationLabel,
        string $personEmail,
        string $personFullName,
        string $personInn,
        string $personPhoneNumber,
        string $personSeries,
        string $personNumber,
        string $personDate,
        string $personCode,
        string $personOrgInn,
        string $personOrgTitle,
        string $personSnilsNumber,
        string $personPassportFile,
        string $personSnilsFile,
        ?string $personInnFile
    ) {
        $this->id = $id;
        $this->guid = $guid;
        $this->createdAt = $createdAt;
        $this->locationId = $locationId;
        $this->locationLabel = $locationLabel;
        $this->personEmail = $personEmail;
        $this->personFullName = $personFullName;
        $this->personInn = $personInn;
        $this->personPhoneNumber = $personPhoneNumber;
        $this->personSeries = $personSeries;
        $this->personNumber = $personNumber;
        $this->personDate = $personDate;
        $this->personCode = $personCode;
        $this->personOrgInn = $personOrgInn;
        $this->personOrgTitle = $personOrgTitle;
        $this->personSnilsNumber = $personSnilsNumber;
        $this->personPassportFile = $personPassportFile;
        $this->personSnilsFile = $personSnilsFile;
        $this->personInnFile = $personInnFile;
    }
}
