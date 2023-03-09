<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserIdentity|UserInterface $user): void
    {
        if (!$user instanceof UserIdentity) {
            throw new CustomUserMessageAccountStatusException('#');
        }
    }

    public function checkPostAuth(UserIdentity|UserInterface $user): void
    {
        if (!$user instanceof UserIdentity) {
            throw new CustomUserMessageAccountStatusException('##');
        }

        if (!$user->isActive()) {
            $exception = new DisabledException('User account is disabled.');
            $exception->setUser($user);
            throw $exception;
        }
    }
}
