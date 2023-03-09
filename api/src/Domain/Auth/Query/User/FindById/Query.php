<?php

declare(strict_types=1);

namespace App\Domain\Auth\Query\User\FindById;

final class Query
{
    public function __construct(readonly int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
