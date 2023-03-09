<?php

declare(strict_types=1);

namespace App\Domain\Auth\Query\User\FindById;

final class User
{
    private int $id;

    private string $publicId;

    private string $email;

    private string $status;

    private string $role;

    private string $passwordHash;

    private string $firstName;

    private string $lastName;

    private string $middleName;

    private string $createdAt;

    public function __construct(
        int $id,
        string $publicId,
        string $email,
        string $status,
        string $role,
        string $passwordHash,
        string $firstName,
        string $lastName,
        string $middleName,
        string $createdAt,
    ) {
        $this->id = $id;
        $this->publicId = $publicId;
        $this->email = $email;
        $this->status = $status;
        $this->role = $role;
        $this->passwordHash = $passwordHash;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPublicId(): string
    {
        return $this->publicId;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
}
