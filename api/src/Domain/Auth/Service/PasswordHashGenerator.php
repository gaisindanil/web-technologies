<?php

declare(strict_types=1);

namespace App\Domain\Auth\Service;

use Symfony\Component\PasswordHasher\PasswordHasherInterface;

final class PasswordHashGenerator implements PasswordHasherInterface
{
    public function hash(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_ARGON2I);
    }

    public function verify(string $hashedPassword, string $plainPassword): bool
    {
        return password_verify($plainPassword, $hashedPassword);
    }

    public function needsRehash(string $hashedPassword): bool
    {
        return false;
    }
}
