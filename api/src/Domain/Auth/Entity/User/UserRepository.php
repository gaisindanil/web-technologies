<?php

declare(strict_types=1);

namespace App\Domain\Auth\Entity\User;

use App\Domain\Common\Types\Id;
use App\Domain\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class UserRepository
{
    private EntityManagerInterface $entityManager;

    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(User::class);
    }

    public function hasByEmail(Email $email): bool
    {
        return $this->repository->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->andWhere('t.email = :email')
            ->setParameter(':email', $email->getValue())
            ->getQuery()->getSingleScalarResult() > 0;
    }

    public function add(User $user): void
    {
        $this->entityManager->persist($user);
    }

    public function findByConfirmToken(string $confirmToken): ?User
    {
        $user = $this->repository->findOneBy(['confirmToken' => $confirmToken]);
        if ($user instanceof User) {
            return $user;
        }
        return null;
    }

    public function findByResetToken(string $resetToken): ?User
    {
        $user = $this->repository->findOneBy(['resetToken' => $resetToken]);
        if ($user instanceof User) {
            return $user;
        }
        return null;
    }

    public function get(int $id): User
    {
        $user = $this->repository->find($id);
        if (!$user instanceof User) {
            throw new EntityNotFoundException('User is not found.');
        }
        return $user;
    }

    public function getByPublicId(Id $publicId): User
    {
        $user = $this->repository->findOneBy(['publicId' => $publicId]);
        if (!$user instanceof User) {
            throw new EntityNotFoundException('User is not found.');
        }
        return $user;
    }

    public function remove(User $user): void
    {
        $this->entityManager->remove($user);
    }
}
