<?php

declare(strict_types=1);

namespace App\Domain\Lead\Entity\Lead;

use App\Domain\Auth\Entity\User\Email;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
final class Person
{
    #[Column(type: 'user_email')]
    private Email $email;

    #[Column(type: 'string')]
    private string $fullName;

    #[Column(type: 'string')]
    private string $inn;

    #[Column(type: 'string')]
    private string $phoneNumber;

    #[Column(type: 'string')]
    private string $series;

    #[Column(type: 'string')]
    private string $number;

    #[Column(type: 'date_immutable')]
    private DateTimeImmutable $date;

    #[Column(type: 'string')]
    private string $code;

    #[Column(type: 'string')]
    private string $orgInn;

    #[Column(type: 'string')]
    private string $ogrTitle;

    #[Column(type: 'string')]
    private string $snilsNumber;

    #[Column(type: 'string')]
    private string $passwordFile;

    #[Column(type: 'string')]
    private string $snilsFile;

    #[Column(type: 'string', nullable: true)]
    private string $innFile;

    public function __construct(
        Email $email,
        string $fullName,
        string $inn,
        string $phoneNumber,
        string $series,
        string $number,
        DateTimeImmutable $date,
        string $code,
        string $orgInn,
        string $ogrTitle,
        string $snilsNumber,
        string $passwordFile,
        ?string $innFile,
        string $snilsFile
    ) {
        $this->email = $email;
        $this->fullName = $fullName;
        $this->inn = $inn;
        $this->phoneNumber = $phoneNumber;
        $this->series = $series;
        $this->number = $number;
        $this->date = $date;
        $this->code = $code;
        $this->ogrTitle = $ogrTitle;
        $this->orgInn = $orgInn;
        $this->snilsNumber = $snilsNumber;
        $this->passwordFile = $passwordFile;
        $this->innFile = $innFile;
        $this->snilsFile = $snilsFile;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getInn(): string
    {
        return $this->inn;
    }

    public function getOgrTitle(): string
    {
        return $this->ogrTitle;
    }

    public function getOrgInn(): string
    {
        return $this->orgInn;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getSeries(): string
    {
        return $this->series;
    }

    public function getSnilsNumber(): string
    {
        return $this->snilsNumber;
    }
}
