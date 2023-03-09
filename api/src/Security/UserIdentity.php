<?php

declare(strict_types=1);

namespace App\Security;

use App\Domain\Auth\Entity\User\Status;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserIdentity implements UserInterface, PasswordAuthenticatedUserInterface
{
    private int $id;
    private string $publicId;
    private string $email;
    private string $passwordHash;
    private string $role;
    private string $status;
    private string $firstName;
    private string $lastName;
    private string $middleName;

    public function __construct(
        int $id,
        string $publicId,
        string $email,
        string $passwordHash,
        string $role,
        string $status,
        string $firstName,
        string $lastName,
        string $middleName
    ) {
        $this->id = $id;
        $this->publicId = $publicId;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->role = $role;
        $this->status = $status;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getEmail(): string
    {
        return $this->email;
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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getPublicId(): string
    {
        return $this->publicId;
    }

    public function getRoles(): array
    {
        return [$this->role];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    public function isActive(): bool
    {
        return $this->status === Status::active()->getName();
    }

    public function isEqualTo(UserInterface $user): bool
    {
        if (!$user instanceof self) {
            return false;
        }

        return
            $this->id === $user->id &&
            $this->passwordHash === $user->passwordHash &&
            $this->role === $user->role &&
            $this->status === $user->status;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->passwordHash;
    }
}
