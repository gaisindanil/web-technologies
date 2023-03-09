<?php

declare(strict_types=1);

namespace App\Domain\Auth\Entity\User;

use App\Domain\Common\Types\Id as PublicId;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use DomainException;

#[ORM\Entity]
#[ORM\Table('users')]
/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(name: 'public_id', type: 'public_id')]
    private PublicId $publicId;

    #[ORM\Column(name: 'status', type: 'user_status')]
    private Status $status;

    #[ORM\Column(name: 'email', type: 'user_email', unique: true)]
    private Email $email;

    #[ORM\Column(name: 'role', type: 'user_role')]
    private Role $role;

    #[ORM\Column(name: 'password_hash', type: 'string')]
    private string $password;

    #[ORM\Embedded(class: FullName::class, columnPrefix: 'full_name_')]
    private FullName $fullName;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    #[ORM\Column(name: 'new_email', type: 'user_email', unique: true, nullable: true)]
    private Email $newEmail;

    #[ORM\Column(type: 'string', unique: true, nullable: true)]
    private ?string $confirmToken;

    public function __construct(
        PublicId $publicId,
        FullName $fullName,
        Status $status,
        Email $email,
        Role $role,
        string $password,
        DateTimeImmutable $createdAt,
        string $confirmToken
    ) {
        $this->publicId = $publicId;
        $this->fullName = $fullName;
        $this->status = $status;
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
        $this->createdAt = $createdAt;
        $this->confirmToken = $confirmToken;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getNewEmail(): Email
    {
        return $this->newEmail;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPublicId(): PublicId
    {
        return $this->publicId;
    }

    public function getFullName(): FullName
    {
        return $this->fullName;
    }

    public function getConfirmToken(): ?string
    {
        return $this->confirmToken;
    }

    public function confirmSignUp(): void
    {
        if (!$this->status->isWait()) {
            throw new DomainException('Аккаунт не ожидает подтверждения.');
        }
        if ($this->confirmToken === null) {
            throw new DomainException('Запрос на подтверждение почты не был отправлен');
        }
        $this->status = Status::active();
        $this->confirmToken = null;
    }

    public function changePassword(string $pass): void
    {
        $this->password = $pass;
    }
}
