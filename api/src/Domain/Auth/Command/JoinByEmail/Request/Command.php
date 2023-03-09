<?php

declare(strict_types=1);

namespace App\Domain\Auth\Command\JoinByEmail\Request;

final class Command
{
    public string $email = '';

    public string $password = '';

    public string $confirmPassword = '';

    public string $firstName = '';

    public string $lastName = '';

    public string $middleName = '';
}
