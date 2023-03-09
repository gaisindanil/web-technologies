<?php

declare(strict_types=1);

namespace App\Domain\Auth\Service;

use Ramsey\Uuid\Uuid;

final class ConfirmTokenGenerator
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
