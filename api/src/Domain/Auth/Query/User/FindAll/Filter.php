<?php

declare(strict_types=1);

namespace App\Domain\Auth\Query\User\FindAll;

use App\Domain\Auth\Entity\User\Status;

final class Filter
{
    public function __construct(readonly ?Status $status)
    {
    }

    public static function byStatus(Status $status): self
    {
        return new self($status);
    }

    public static function default(): self
    {
        return new self(null);
    }
}
