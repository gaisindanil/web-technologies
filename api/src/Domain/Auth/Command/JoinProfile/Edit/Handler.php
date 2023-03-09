<?php

declare(strict_types=1);

namespace App\Domain\Auth\Command\JoinProfile\Edit;

use App\Domain\Auth\Entity\Profile\ProfileRepository;
use App\Domain\Flusher;

final class Handler
{
    private Flusher $flusher;

    private ProfileRepository $profileRepository;

    public function __construct(ProfileRepository $profileRepository, Flusher $flusher)
    {
        $this->flusher = $flusher;
        $this->profileRepository = $profileRepository;
    }

    public function handle(Command $command): void
    {
        $profile = $this->profileRepository->get($command->profileId);

        $profile->edit(
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
