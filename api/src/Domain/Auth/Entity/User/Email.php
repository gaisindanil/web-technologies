<?php

declare(strict_types=1);

namespace App\Domain\Auth\Entity\User;

use App\Domain\InvalidArgumentException;
use Webmozart\Assert\Assert;

final class Email
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Incorrect email.');
        }
        $this->value = mb_strtolower($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(self $email): bool
    {
        return $this->getValue() === $email->getValue();
    }
}
