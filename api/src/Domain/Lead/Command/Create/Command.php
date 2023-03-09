<?php

declare(strict_types=1);

namespace App\Domain\Lead\Command\Create;

final class Command
{
    public string $id;
    public string $snils_number;
    public string $location_id;
    public string $location_label;
    public string $org_inn;
    public string $org_title;
    public string $person_email;
    public string $person_fullname;
    public string $person_inn;
    public string $person_phone_number;
    public string $passport_series;
    public string $passport_number;
    public string $passport_date;
    public string $passport_code;

    public string $filePassword;

    public string $fileSnils;

    public string $fileInn;

    public function __construct(
        string $id,
        string $snils_number,
        string $location_id,
        string $location_label,
        string $org_inn,
        string $org_title,
        string $person_email,
        string $person_fullname,
        string $person_inn,
        string $person_phone_number,
        string $passport_series,
        string $passport_number,
        string $passport_date,
        string $passport_code,
        string $filePassword,
        string $fileSnils,
        ?string $fileInn
    ) {
        $this->id = $id;
        $this->snils_number = $snils_number;
        $this->location_id = $location_id;
        $this->location_label = $location_label;
        $this->org_inn = $org_inn;
        $this->org_title = $org_title;
        $this->person_email = $person_email;
        $this->person_fullname = $person_fullname;
        $this->person_inn = $person_inn;
        $this->person_phone_number = $person_phone_number;
        $this->passport_series = $passport_series;
        $this->passport_number = $passport_number;
        $this->passport_date = $passport_date;
        $this->passport_code = $passport_code;
        $this->filePassword = $filePassword;
        $this->fileSnils = $fileSnils;
        $this->fileInn = $fileInn;
    }
}
