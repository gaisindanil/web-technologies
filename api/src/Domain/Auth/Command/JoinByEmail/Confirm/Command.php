<?php

declare(strict_types=1);

namespace App\Domain\Auth\Command\JoinByEmail\Confirm;

final class Command
{
    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }
}
