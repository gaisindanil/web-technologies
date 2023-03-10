<?php

declare(strict_types=1);

namespace App\Domain\Auth\Query\User\FindByCredentials;

final class Query
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = mb_strtolower($email);
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
