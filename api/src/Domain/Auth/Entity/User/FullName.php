<?php

declare(strict_types=1);

namespace App\Domain\Auth\Entity\User;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
final class FullName
{
    #[Column(name: 'first_name', type: 'string')]
    private string $firstName;

    #[Column(name: 'last_name', type: 'string')]
    private string $lastName;

    #[Column(name: 'middle_name', type: 'string')]
    private string $middleName;

    public function __construct(
        string $firstName,
        string $lastName,
        string $middleName
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }
}
