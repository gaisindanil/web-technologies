<?php

declare(strict_types=1);

namespace App\Domain\Auth\Command\JoinProfile\Request;

use App\Domain\Auth\Entity\User\UserRepository;
use App\Domain\Common\Types\Id;
use App\Domain\Flusher;

final class Handler
{
    private Flusher $flusher;

    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository,
        Flusher $flusher
    ) {
        $this->flusher = $flusher;
        $this->userRepository = $userRepository;
    }

    public function handle(Command $command): void
    {
        $user = $this->userRepository->get($command->userId);

        $user->joinProfile(
            Id::next(),
            $command->title,
            $command->contactPerson,
            $command->contactPhone,
            $command->ogrn,
            $command->inn,
            $command->kpp
        );

        $this->flusher->flush();
    }
}
