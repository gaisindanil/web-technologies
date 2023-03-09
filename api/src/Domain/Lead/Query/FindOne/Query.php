<?php

declare(strict_types=1);

namespace App\Domain\Lead\Query\FindOne;

final class Query
{
    public function __construct(
        readonly string $guid
    ) {
    }
}
