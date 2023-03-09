<?php

declare(strict_types=1);

namespace App\Security;

use App\Domain\Auth\Entity\User\Status;
use App\Domain\Auth\Query\User\FindByCredentials\Fetcher;
use App\Domain\Auth\Query\User\FindByCredentials\Query;
use App\Domain\Auth\Query\User\FindByCredentials\User;
use Doctrine\DBAL\Exception;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{
    private Fetcher $fetcher;

    public function __construct(Fetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * @throws Exception
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof UserIdentity) {
            throw new UnsupportedUserException('Invalid user class' . $user::class);
        }

        $user = $this->loadUser(new Query($user->getEmail()));

        if (!$user) {
            throw new UserNotFoundException('');
        }

        if ($user->getStatus() === Status::blocked()->getName()) {
            throw new CustomUserMessageAuthenticationException('User is blocked');
        }

        return self::identityByUser($user);
    }

    public function supportsClass(string $class): bool
    {
        return $class === UserIdentity::class;
    }

    /**
     * @throws Exception
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->loadUser(new Query($identifier));

        if (!$user) {
            throw new UserNotFoundException('');
        }

        return self::identityByUser($user);
    }

    /**
     * @throws Exception
     */
    private function loadUser(Query $query): ?User
    {
        return $this->fetcher->fetch($query);
    }

    private static function identityByUser(User $user): UserIdentity
    {
        return new UserIdentity(
            $user->getId(),
            $user->getPublicId(),
            $user->getEmail(),
            $user->getPasswordHash(),
            $user->getRole(),
            $user->getStatus(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getMiddleName()
        );
    }
}
