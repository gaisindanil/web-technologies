<?php

declare(strict_types=1);

namespace App\Domain\Auth\Entity\User;

use Webmozart\Assert\Assert;

final class Status
{
    private const STATUS_NEW = 'new';
    private const STATUS_WAIT = 'wait';
    private const STATUS_ACTIVE = 'active';
    private const STATUS_BLOCKED = 'blocked';

    private string $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::STATUS_NEW,
            self::STATUS_WAIT,
            self::STATUS_ACTIVE,
            self::STATUS_BLOCKED,
        ]);
        $this->name = $name;
    }

    public static function new(): self
    {
        return new self(self::STATUS_NEW);
    }

    public static function active(): self
    {
        return new self(self::STATUS_ACTIVE);
    }

    public static function wait(): self
    {
        return new self(self::STATUS_WAIT);
    }

    public static function blocked(): self
    {
        return new self(self::STATUS_BLOCKED);
    }

    public function isEqual(self $status): bool
    {
        return $this->getName() === $status->getName();
    }

    public function isNew(): bool
    {
        return $this->name === self::STATUS_NEW;
    }

    public function isActive(): bool
    {
        return $this->name === self::STATUS_ACTIVE;
    }

    public function isWait(): bool
    {
        return $this->name === self::STATUS_WAIT;
    }

    public function isBlocked(): bool
    {
        return $this->name === self::STATUS_BLOCKED;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
