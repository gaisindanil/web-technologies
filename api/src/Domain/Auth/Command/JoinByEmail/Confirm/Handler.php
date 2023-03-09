<?php

declare(strict_types=1);

namespace App\Domain\Auth\Command\JoinByEmail\Confirm;

use App\Domain\Auth\Entity\User\UserRepository;
use App\Domain\Flusher;
use DomainException;

final class Handler
{
    private Flusher $flusher;
    private UserRepository $userRepository;

    public function __construct(Flusher $flusher, UserRepository $userRepository)
    {
        $this->flusher = $flusher;
        $this->userRepository = $userRepository;
    }

    public function handle(Command $command): void
    {
        $user = $this->userRepository->findByConfirmToken($command->token);

        if ($user === null) {
            throw new DomainException('User not found.');
        }

        $user->confirmSignUp();

        $this->flusher->flush();
    }
}
